<?php

declare(strict_types=1);

namespace SightPress\Website\Markdown;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\Node;
use League\CommonMark\Node\StringContainerHelper;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\Xml;

/**
 * Renders section headings with a link to the section next to them, outside the heading, so the heading's name stays
 * its own text. The link is named "Link to this section: <heading>" for screen readers; sighted people see "#".
 */
final class HeadingRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        if (!$node instanceof Heading) {
            throw new \InvalidArgumentException('Expected a heading, got ' . $node::class);
        }

        $level = $node->getLevel();
        /** @var array<string, string> $attributes */
        $attributes = $node->data->get('attributes', []);
        $heading = new HtmlElement('h' . $level, $attributes, $childRenderer->renderNodes($node->children()));
        $id = $attributes['id'] ?? null;
        if ($level === 1 || $id === null) {
            return $heading;
        }

        $label = 'Link to this section: ' . StringContainerHelper::getChildText($node);
        $anchor = new HtmlElement('a', ['class' => 'heading-anchor', 'href' => '#' . $id], [
            new HtmlElement('span', ['aria-hidden' => 'true'], '#'),
            new HtmlElement('span', ['class' => 'visually-hidden'], Xml::escape($label)),
        ]);

        return new HtmlElement('div', ['class' => 'heading-wrap'], [$heading, $anchor]);
    }
}
