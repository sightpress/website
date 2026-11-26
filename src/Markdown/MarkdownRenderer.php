<?php

declare(strict_types=1);

namespace SightPress\Website\Markdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Node;
use League\CommonMark\Node\StringContainerHelper;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Renderer\HtmlRenderer;

/**
 * Turns an article's Markdown into HTML and checks it the way SightPress checks a page before publishing: one main
 * heading, no skipped heading levels, alt text on every image, and link text that makes sense on its own.
 */
final class MarkdownRenderer
{
    /** Link text that doesn't say where the link goes. */
    private const array VAGUE_LINK_TEXT = [
        'click here', 'here', 'read more', 'more', 'link', 'this link', 'this', 'this page', 'click', 'go', 'learn more',
    ];

    private readonly MarkdownParser $parser;
    private readonly HtmlRenderer $renderer;

    public function __construct()
    {
        $environment = new Environment([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'footnote' => [
                'backref_class' => 'footnote-backref',
                'container_add_hr' => false,
            ],
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new FootnoteExtension());
        $environment->addEventListener(DocumentParsedEvent::class, new HeadingIds());
        $environment->addRenderer(Heading::class, new HeadingRenderer(), 10);

        $this->parser = new MarkdownParser($environment);
        $this->renderer = new HtmlRenderer($environment);
    }

    public function render(string $markdown): RenderedMarkdown
    {
        $document = $this->parser->parse($markdown);
        $problems = $this->check($document);
        $title = $this->takeTitle($document);

        $html = trim($this->renderer->renderDocument($document)->getContent());
        // Count the words a reader sees: a space at each block boundary so adjacent blocks don't merge, and
        // entities decoded so `&quot;` or `&#039;` aren't counted as words.
        $text = (string) preg_replace('#<(?:br|/?(?:p|li|h[1-6]|blockquote|pre|t[dh]|d[td]|figcaption))\b[^>]*>#i', ' $0 ', $html);
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $words = preg_match_all("/[\\p{L}\\p{N}][\\p{L}\\p{N}'’-]*/u", $text);

        return new RenderedMarkdown($title, $html, (int) $words, $problems);
    }

    /**
     * Renders one line of inline Markdown (a caption or a credit) without the surrounding paragraph, and checks its links.
     */
    public function inline(string $markdown): RenderedMarkdown
    {
        $document = $this->parser->parse(str_replace("\n", ' ', $markdown));
        $problems = [];
        foreach ($document->iterator() as $node) {
            if ($node instanceof Link) {
                $problems = [...$problems, ...$this->checkLink($node)];
            } elseif (!$node instanceof Document && $node->parent() instanceof Document && !$node instanceof Paragraph) {
                $problems[] = sprintf('"%s" must be a single line of text.', $markdown);
            }
        }
        $html = trim($this->renderer->renderDocument($document)->getContent());
        $html = (string) preg_replace('#^<p>(.*)</p>$#s', '$1', $html);

        return new RenderedMarkdown('', $html, 0, $problems);
    }

    /**
     * @return list<string>
     */
    private function check(Document $document): array
    {
        $problems = [];
        $mainHeadings = 0;
        $previousLevel = 0;
        foreach ($document->iterator() as $node) {
            if ($node instanceof Heading) {
                $level = $node->getLevel();
                $text = StringContainerHelper::getChildText($node);
                if ($level === 1) {
                    ++$mainHeadings;
                }
                if ($previousLevel === 0 && $level !== 1) {
                    $problems[] = sprintf('The first heading, "%s", must be a main heading (#).', $text);
                } elseif ($level > $previousLevel + 1 && $previousLevel !== 0) {
                    $problems[] = sprintf('The heading "%s" skips from level %d to level %d.', $text, $previousLevel, $level);
                }
                $previousLevel = $level;
            } elseif ($node instanceof Image) {
                if (trim(StringContainerHelper::getChildText($node)) === '') {
                    $problems[] = sprintf('The image %s has no alt text.', $node->getUrl());
                }
            } elseif ($node instanceof Link) {
                $problems = [...$problems, ...$this->checkLink($node)];
            }
        }
        if ($mainHeadings !== 1) {
            $problems[] = sprintf('An article needs exactly one main heading (#); this one has %d.', $mainHeadings);
        }

        return $problems;
    }

    /**
     * @return list<string>
     */
    private function checkLink(Link $link): array
    {
        $text = trim(StringContainerHelper::getChildText($link, [Image::class]));
        foreach ($link->iterator() as $child) {
            if ($child instanceof Image) {
                $text .= ' ' . StringContainerHelper::getChildText($child);
            }
        }
        $text = trim($text);
        $plain = strtolower(trim($text, " \t.:!?…"));

        if ($plain === '') {
            return [sprintf('The link to %s has no text.', $link->getUrl())];
        }
        if (\in_array($plain, self::VAGUE_LINK_TEXT, true)) {
            return [sprintf('The link text "%s" doesn\'t say where the link goes (%s).', $text, $link->getUrl())];
        }
        $path = (string) parse_url($link->getUrl(), PHP_URL_PATH);
        if (str_ends_with(strtolower($path), '.pdf') && !str_contains(strtolower($text), 'pdf')) {
            return [sprintf('The link "%s" goes to a PDF but doesn\'t say so; add the type and size, for example "(PDF, 2 MB)".', $text)];
        }

        return [];
    }

    /**
     * Removes the main heading, and the "By …" and date lines under it, from the body: the page template shows them.
     */
    private function takeTitle(Document $document): string
    {
        $heading = null;
        foreach ($document->children() as $node) {
            if ($node instanceof Heading && $node->getLevel() === 1) {
                $heading = $node;
                break;
            }
        }
        if ($heading === null) {
            return '';
        }

        $title = StringContainerHelper::getChildText($heading);
        $next = $heading->next();
        $heading->detach();
        if ($this->isParagraphMatching($next, '/^By [\p{L} .\'-]+$/u')) {
            $after = $next?->next();
            $next?->detach();
            $next = $after;
        }
        if ($this->isParagraphMatching($next, '/^\d{1,2} [A-Z][a-z]+ \d{4}$/')) {
            $next?->detach();
        }

        return $title;
    }

    private function isParagraphMatching(?Node $node, string $pattern): bool
    {
        return $node instanceof Paragraph && preg_match($pattern, trim(StringContainerHelper::getChildText($node))) === 1;
    }
}
