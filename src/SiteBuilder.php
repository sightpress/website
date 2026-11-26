<?php

declare(strict_types=1);

namespace SightPress\Website;

use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Renders every page of the website into an Output.
 */
final class SiteBuilder
{
    private readonly Environment $twig;
    private readonly string $url;

    /**
     * @param array<string, mixed> $site     src/site.php
     * @param array{sections: list<string>, tags: array<string, string>} $taxonomy src/taxonomy.php
     */
    public function __construct(private readonly array $site, private readonly array $taxonomy, string $templates)
    {
        $this->url = (string) $site['url'];
        $this->twig = new Environment(new FilesystemLoader($templates), [
            'strict_variables' => true,
            'autoescape' => 'html',
            'cache' => false,
        ]);
        $this->twig->addGlobal('site', $site);
        $this->twig->addFilter(new TwigFilter('long_date', self::longDate(...)));
        $this->twig->addFilter(new TwigFilter('tag_label', fn (string $tag): string => $this->taxonomy['tags'][$tag] ?? $tag));
        $this->twig->addFilter(new TwigFilter('slug', Slug::of(...)));
        $this->twig->addFilter(new TwigFilter('absolute', fn (string $path): string => $this->absolute($path)));
        $this->twig->addFunction(new TwigFunction('share_links', $this->shareLinks(...)));
        $this->twig->addFunction(new TwigFunction('docs', fn (string $path = ''): string => $site['docsLatest'] . $path));
    }

    /**
     * @param list<Article> $articles newest first, published only (unless building a draft preview)
     */
    public function build(array $articles): Output
    {
        $output = new Output();
        $latest = \array_slice($articles, 0, 3);

        $output->add('/', $this->page('home.twig', [
            'path' => '/',
            'nav' => 'home',
            'title' => 'SightPress: an accessible, open-source CMS for everyone',
            'description' => 'SightPress is an open-source CMS for everyone, designed with blind and low-vision creators and audiences in mind. Test release ' . $this->site['release']['version'] . ' is out for developers.',
            'socialTitle' => 'SightPress: Beyond sight.',
            'modified' => $this->site['pages']['home'],
            'latest' => $latest,
        ], fn (array $page): array => [
            $this->webPage($page, 'WebPage', ['about' => ['@id' => $this->url . '/#software']]),
            $this->software(),
        ]));

        $output->add('/about/', $this->page('about.twig', [
            'path' => '/about/',
            'nav' => 'about',
            'title' => 'About SightPress and its creator',
            'description' => 'Why SightPress exists, who it is for, how we build and test it, and the blind web developer who created it.',
            'modified' => $this->site['pages']['about'],
            'goingBlind' => $this->find($articles, 'going-blind-as-a-web-developer'),
        ], fn (array $page): array => [
            $this->webPage($page, 'AboutPage', ['mainEntity' => ['@id' => $this->url . '/#organization']]),
        ]));

        $output->add('/features/', $this->page('features.twig', [
            'path' => '/features/',
            'nav' => 'features',
            'title' => 'Features: what SightPress can do today and what comes next',
            'description' => 'What works in SightPress test release ' . $this->site['release']['version'] . ', what is being built now, and the plans before and after version 1.0.',
            'modified' => $this->site['pages']['features'],
        ], fn (array $page): array => [
            $this->webPage($page, 'WebPage', ['about' => ['@id' => $this->url . '/#software']]),
            $this->software(),
        ]));

        $output->add('/faq/', $this->page('faq.twig', [
            'path' => '/faq/',
            'nav' => 'faq',
            'title' => 'Frequently asked questions about SightPress',
            'description' => 'Answers to common questions about SightPress: who it is for, screen readers, accessible content, open source, what you need to run it, AI and when you can try it.',
            'modified' => $this->site['pages']['faq'],
        ], fn (array $page): array => [
            $this->webPage($page, 'FAQPage', ['mainEntity' => $this->faqQuestions($page)]),
        ]));

        $output->add('/accessibility/', $this->page('accessibility.twig', [
            'path' => '/accessibility/',
            'nav' => null,
            'title' => 'Accessibility statement for sightpress.org',
            'description' => 'How accessible the SightPress website is, how we test it, and how to tell us about a barrier.',
            'modified' => $this->site['pages']['accessibility'],
        ], fn (array $page): array => [$this->webPage($page, 'WebPage')]));

        $output->add('/404.html', $this->page('404.twig', [
            'path' => '/404.html',
            'nav' => null,
            'title' => 'Page not found',
            'description' => 'This page doesn’t exist on sightpress.org.',
            'modified' => $this->site['pages']['home'],
            'robots' => 'noindex',
        ], fn (array $page): array => []));

        $this->buildArticles($output, $articles);
        $output->add('/sitemap.xml', $this->twig->render('sitemap.xml.twig', ['entries' => $this->sitemap($articles)]));
        $output->add('/llms.txt', $this->twig->render('llms.txt.twig', ['articles' => $articles]));

        return $output;
    }

    /**
     * @param list<Article> $articles
     */
    private function buildArticles(Output $output, array $articles): void
    {
        $sections = $this->groupBySection($articles);
        $tags = $this->groupByTag($articles);

        $output->add('/blog/', $this->page('blog.twig', [
            'path' => '/blog/',
            'nav' => 'blog',
            'title' => 'Blog',
            'description' => 'The SightPress blog: articles about SightPress, accessible publishing and working as a blind web developer, by Pedro Ferreira.',
            'modified' => $articles === [] ? $this->site['pages']['home'] : $this->newest($articles),
            'articles' => $articles,
            'sections' => $sections,
            'tags' => $tags,
        ], fn (array $page): array => [$this->collection($page, $articles, true)]));

        foreach ($sections as $section => $list) {
            $output->add('/blog/section/' . Slug::of($section) . '/', $this->page('article-list.twig', [
                'path' => '/blog/section/' . Slug::of($section) . '/',
                'nav' => 'blog',
                'title' => $section,
                'heading' => $section,
                'kind' => 'section',
                'description' => \sprintf('SightPress blog articles in the section “%s”.', $section),
                'modified' => $this->newest($list),
                'articles' => $list,
            ], fn (array $page): array => [$this->collection($page, $list, false)]));
        }
        foreach ($tags as $tag => $list) {
            $label = $this->taxonomy['tags'][$tag];
            $output->add('/blog/tag/' . $tag . '/', $this->page('article-list.twig', [
                'path' => '/blog/tag/' . $tag . '/',
                'nav' => 'blog',
                'title' => 'Articles tagged “' . $label . '”',
                'heading' => 'Articles tagged “' . $label . '”',
                'kind' => 'tag',
                'description' => \sprintf('SightPress blog articles tagged “%s”.', $label),
                'modified' => $this->newest($list),
                'articles' => $list,
            ], fn (array $page): array => [$this->collection($page, $list, false)]));
        }

        $count = \count($articles);
        foreach ($articles as $index => $article) {
            $page = [
                'path' => $article->path(),
                'nav' => 'blog',
                'title' => $article->title,
                'description' => $article->description,
                'modified' => $article->lastModified(),
                'type' => 'article',
                'article' => $article,
                'markdown' => $article->path() . 'index.md',
                'newer' => $index > 0 ? $articles[$index - 1] : null,
                'older' => $index < $count - 1 ? $articles[$index + 1] : null,
                'related' => $this->related($article, $articles),
            ];
            if ($article->image !== null) {
                $page['image'] = ['path' => $article->image, 'width' => 1200, 'height' => 630, 'alt' => $article->imageAlt];
            }
            $output->add($article->path(), $this->page('article.twig', $page, fn (array $page): array => [
                $this->posting($page, $article),
                $this->breadcrumbs($article),
            ]));
            $output->add($article->path() . 'index.md', $this->markdownAlternate($article));
        }

        $output->add('/blog/feed.xml', $this->twig->render('feed.xml.twig', [
            'articles' => $articles,
            'updated' => $articles === [] ? $this->site['pages']['home'] : $this->newest($articles),
            'contents' => array_map(fn (Article $a): string => $this->absoluteLinks($a->html, $a->path()), $articles),
        ]));
    }

    /**
     * @param array<string, mixed> $page
     * @param \Closure(array<string, mixed>): list<array<string, mixed>> $graph extra JSON-LD nodes for this page
     */
    private function page(string $template, array $page, \Closure $graph): string
    {
        $page += [
            'type' => 'website',
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
            'image' => $this->site['shareImage'],
            'markdown' => null,
            'socialTitle' => null,
        ];
        $page['url'] = $this->absolute($page['path']);
        $page['fullTitle'] = $page['path'] === '/' ? $page['title'] : $page['title'] . ' | SightPress';
        $nodes = $page['robots'] === 'noindex' ? [] : [
            $this->organization(),
            $this->person(),
            $this->website(),
            ...$graph($page),
        ];
        $page['jsonLd'] = $nodes === [] ? null : json_encode(
            ['@context' => 'https://schema.org', '@graph' => $nodes],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_THROW_ON_ERROR,
        );

        return $this->twig->render($template, ['page' => $page]);
    }

    // Structured data ---------------------------------------------------------------------------------------------

    /** @return array<string, mixed> */
    private function organization(): array
    {
        return [
            '@type' => 'Organization',
            '@id' => $this->url . '/#organization',
            'name' => 'SightPress',
            'url' => $this->url . '/',
            'logo' => ['@type' => 'ImageObject', 'url' => $this->url . '/brand/favicons/icon-512.png', 'width' => 512, 'height' => 512],
            'email' => $this->site['email'],
            'slogan' => $this->site['motto'],
            'sameAs' => [$this->site['github']],
            'founder' => ['@id' => $this->url . '/#pedro-ferreira'],
        ];
    }

    /** @return array<string, mixed> */
    private function person(): array
    {
        return [
            '@type' => 'Person',
            '@id' => $this->url . '/#pedro-ferreira',
            'name' => 'Pedro Ferreira',
            'jobTitle' => 'Founder and lead developer of SightPress',
            'image' => $this->url . '/assets/pedro.jpg',
            'worksFor' => ['@id' => $this->url . '/#organization'],
            'url' => $this->url . '/about/#creator',
            'birthPlace' => ['@type' => 'Place', 'name' => 'Lisbon, Portugal'],
            'knowsAbout' => ['PHP', 'Web development', 'Open source', 'Web accessibility', 'Screen readers'],
        ];
    }

    /** @return array<string, mixed> */
    private function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => $this->url . '/#website',
            'name' => 'SightPress',
            'url' => $this->url . '/',
            'description' => $this->site['description'],
            'publisher' => ['@id' => $this->url . '/#organization'],
            'inLanguage' => 'en-GB',
        ];
    }

    /**
     * @param array<string, mixed> $page
     * @param array<string, mixed> $extra
     *
     * @return array<string, mixed>
     */
    private function webPage(array $page, string $type, array $extra = []): array
    {
        return [
            '@type' => $type,
            '@id' => $page['url'] . '#webpage',
            'url' => $page['url'],
            'name' => $page['fullTitle'],
            'description' => $page['description'],
            'inLanguage' => 'en-GB',
            'isPartOf' => ['@id' => $this->url . '/#website'],
            'dateModified' => $page['modified'],
            'primaryImageOfPage' => $this->imageObject($page['image']),
            ...$extra,
        ];
    }

    /** @return array<string, mixed> */
    private function software(): array
    {
        $release = $this->site['release'];

        return [
            '@type' => 'SoftwareApplication',
            '@id' => $this->url . '/#software',
            'name' => 'SightPress',
            'description' => $this->site['description'],
            'url' => $this->url . '/',
            'applicationCategory' => 'WebApplication',
            'applicationSubCategory' => 'Content management system',
            'operatingSystem' => 'Linux, macOS, Windows (with Docker)',
            'softwareVersion' => $release['version'],
            'datePublished' => $release['date'],
            'releaseNotes' => $release['notes'],
            'downloadUrl' => 'https://packagist.org/packages/sightpress/skeleton',
            'softwareHelp' => ['@type' => 'CreativeWork', 'url' => $this->site['docs']],
            'license' => 'https://spdx.org/licenses/GPL-3.0-or-later.html',
            'isAccessibleForFree' => true,
            'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'GBP'],
            'creativeWorkStatus' => 'Test release: not ready for live sites until version 1.0',
            'author' => ['@id' => $this->url . '/#organization'],
            'creator' => ['@id' => $this->url . '/#pedro-ferreira'],
            'keywords' => 'CMS, accessibility, WCAG 2.2 AA, ATAG 2.0, screen reader, blind, low vision, open source, PHP, multilingual, multi-site',
        ];
    }

    /**
     * @param array<string, mixed> $page
     *
     * @return list<array<string, mixed>>
     */
    private function faqQuestions(array $page): array
    {
        $questions = [];
        $html = $this->twig->render('faq.twig', ['page' => $page + ['jsonLd' => null]]);
        // The questions and answers come from the rendered page, so the two can never disagree.
        preg_match('#<ul class="faq">(.*?)</ul>#s', $html, $faq);
        preg_match_all('#<h2[^>]*>(.*?)</h2>\s*<p>(.*?)</p>#s', $faq[1] ?? '', $pairs, PREG_SET_ORDER);
        foreach ($pairs as [, $question, $answer]) {
            $questions[] = [
                '@type' => 'Question',
                'name' => html_entity_decode(strip_tags($question), ENT_QUOTES | ENT_HTML5),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => html_entity_decode(trim((string) preg_replace('/\s+/', ' ', strip_tags($answer))), ENT_QUOTES | ENT_HTML5),
                ],
            ];
        }
        if ($questions === []) {
            throw new \LogicException('The FAQ page has no questions: faq.twig and SiteBuilder::faqQuestions() disagree.');
        }

        return $questions;
    }

    /**
     * @param array<string, mixed> $page
     * @param list<Article> $articles
     *
     * @return array<string, mixed>
     */
    private function collection(array $page, array $articles, bool $isBlog): array
    {
        $node = $this->webPage($page, $isBlog ? 'Blog' : 'CollectionPage', [
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => array_map(fn (Article $a, int $i): array => [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'url' => $this->absolute($a->path()),
                    'name' => $a->title,
                ], $articles, array_keys($articles)),
            ],
        ]);
        if ($isBlog) {
            $node['publisher'] = ['@id' => $this->url . '/#organization'];
        }

        return $node;
    }

    /**
     * @param array<string, mixed> $page
     *
     * @return array<string, mixed>
     */
    private function posting(array $page, Article $article): array
    {
        return [
            '@type' => 'BlogPosting',
            '@id' => $page['url'] . '#article',
            'mainEntityOfPage' => $page['url'],
            'url' => $page['url'],
            'headline' => $article->title,
            'description' => $article->description,
            'datePublished' => $article->published,
            'dateModified' => $article->lastModified(),
            'author' => ['@id' => $this->url . '/#pedro-ferreira'],
            'publisher' => ['@id' => $this->url . '/#organization'],
            'isPartOf' => ['@id' => $this->url . '/blog/#webpage'],
            'inLanguage' => 'en-GB',
            'articleSection' => $article->section,
            'keywords' => array_map(fn (string $t): string => $this->taxonomy['tags'][$t], $article->tags),
            'wordCount' => $article->words,
            'image' => $this->imageObject($page['image']),
            ...($article->copies === [] ? [] : ['sameAs' => $article->copies]),
        ];
    }

    /** @return array<string, mixed> */
    private function breadcrumbs(Article $article): array
    {
        $items = [
            ['Home', '/'],
            ['Blog', '/blog/'],
            [$article->section, '/blog/section/' . Slug::of($article->section) . '/'],
            [$article->title, $article->path()],
        ];

        return [
            '@type' => 'BreadcrumbList',
            '@id' => $this->absolute($article->path()) . '#breadcrumbs',
            'itemListElement' => array_map(fn (array $item, int $i): array => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item[0],
                'item' => $this->absolute($item[1]),
            ], $items, array_keys($items)),
        ];
    }

    /**
     * @param array<string, mixed> $image
     *
     * @return array<string, mixed>
     */
    private function imageObject(array $image): array
    {
        return [
            '@type' => 'ImageObject',
            'url' => $this->absolute((string) $image['path']),
            'width' => $image['width'],
            'height' => $image['height'],
        ];
    }

    // Helpers -----------------------------------------------------------------------------------------------------

    /**
     * Plain links to each network's own sharing page, in the same order everywhere. Nothing loads from these
     * networks until someone follows a link.
     *
     * @return list<array{label: string, href: string, icon: string}>
     */
    public function shareLinks(string $url, string $text, string $subject = 'Have you seen SightPress?'): array
    {
        $u = rawurlencode($url);
        $t = rawurlencode($text);
        $tu = rawurlencode($text . ' ' . $url);
        $sprite = '/assets/share-icons.svg#share-';

        return [
            ['label' => 'Share on Facebook', 'href' => "https://www.facebook.com/sharer/sharer.php?u=$u", 'icon' => $sprite . 'facebook'],
            ['label' => 'Share on X', 'href' => "https://x.com/intent/post?text=$t&url=$u", 'icon' => $sprite . 'x'],
            ['label' => 'Share on LinkedIn', 'href' => "https://www.linkedin.com/sharing/share-offsite/?url=$u", 'icon' => $sprite . 'linkedin'],
            ['label' => 'Share on Bluesky', 'href' => "https://bsky.app/intent/compose?text=$tu", 'icon' => $sprite . 'bluesky'],
            ['label' => 'Share on Threads', 'href' => "https://www.threads.com/intent/post?text=$tu", 'icon' => $sprite . 'threads'],
            ['label' => 'Share on Reddit', 'href' => "https://www.reddit.com/submit?url=$u&title=$t", 'icon' => $sprite . 'reddit'],
            ['label' => 'Share on WhatsApp', 'href' => "https://wa.me/?text=$tu", 'icon' => $sprite . 'whatsapp'],
            ['label' => 'Share on Telegram', 'href' => "https://t.me/share/url?url=$u&text=$t", 'icon' => $sprite . 'telegram'],
            ['label' => 'Share by email', 'href' => 'mailto:?subject=' . rawurlencode($subject) . '&body=' . $t . '%0A%0A' . $u, 'icon' => '/brand/icons/sprite.svg#sp-icon-mail'],
        ];
    }

    public static function longDate(string $date): string
    {
        return (new \DateTimeImmutable($date))->format('j F Y');
    }

    private function absolute(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : $this->url . $path;
    }

    /** Makes the links in an article absolute, for the feed. */
    private function absoluteLinks(string $html, string $path): string
    {
        $base = $this->absolute($path);
        $html = (string) preg_replace('/(href|src)="#/', '$1="' . $base . '#', $html);

        return (string) preg_replace('/(href|src)="\//', '$1="' . $this->url . '/', $html);
    }

    /**
     * @param list<Article> $articles
     */
    private function find(array $articles, string $slug): ?Article
    {
        foreach ($articles as $article) {
            if ($article->slug === $slug) {
                return $article;
            }
        }

        return null;
    }

    /**
     * @param list<Article> $articles
     */
    private function newest(array $articles): string
    {
        $dates = array_map(static fn (Article $a): string => $a->lastModified(), $articles);

        return $dates === [] ? '' : max($dates);
    }

    /**
     * Up to three other articles that share the most tags with this one; newer first when tied.
     *
     * @param list<Article> $articles
     *
     * @return list<Article>
     */
    private function related(Article $article, array $articles): array
    {
        $scored = [];
        foreach ($articles as $position => $other) {
            $shared = \count(array_intersect($article->tags, $other->tags));
            if ($other->slug !== $article->slug && $shared > 0) {
                $scored[] = [$shared, $position, $other];
            }
        }
        usort($scored, static fn (array $a, array $b): int => [$b[0], $a[1]] <=> [$a[0], $b[1]]);

        return array_map(static fn (array $s): Article => $s[2], \array_slice($scored, 0, 3));
    }

    /**
     * @param list<Article> $articles
     *
     * @return array<string, list<Article>> in the order of src/taxonomy.php
     */
    private function groupBySection(array $articles): array
    {
        $groups = [];
        foreach ($this->taxonomy['sections'] as $section) {
            $list = array_values(array_filter($articles, static fn (Article $a): bool => $a->section === $section));
            if ($list !== []) {
                $groups[$section] = $list;
            }
        }

        return $groups;
    }

    /**
     * @param list<Article> $articles
     *
     * @return array<string, list<Article>> sorted by label
     */
    private function groupByTag(array $articles): array
    {
        $groups = [];
        foreach ($articles as $article) {
            foreach ($article->tags as $tag) {
                $groups[$tag][] = $article;
            }
        }
        uksort($groups, fn (string $a, string $b): int => strcasecmp($this->taxonomy['tags'][$a], $this->taxonomy['tags'][$b]));

        return $groups;
    }

    /**
     * @param list<Article> $articles
     *
     * @return list<array{loc: string, lastmod: string}>
     */
    private function sitemap(array $articles): array
    {
        $pages = $this->site['pages'];
        $entries = [
            ['loc' => '/', 'lastmod' => $pages['home']],
            ['loc' => '/about/', 'lastmod' => $pages['about']],
            ['loc' => '/features/', 'lastmod' => $pages['features']],
            ['loc' => '/faq/', 'lastmod' => $pages['faq']],
            ['loc' => '/blog/', 'lastmod' => $articles === [] ? $pages['home'] : $this->newest($articles)],
            ['loc' => '/accessibility/', 'lastmod' => $pages['accessibility']],
        ];
        foreach ($this->groupBySection($articles) as $section => $list) {
            $entries[] = ['loc' => '/blog/section/' . Slug::of($section) . '/', 'lastmod' => $this->newest($list)];
        }
        foreach ($this->groupByTag($articles) as $tag => $list) {
            $entries[] = ['loc' => '/blog/tag/' . $tag . '/', 'lastmod' => $this->newest($list)];
        }
        foreach ($articles as $article) {
            $entries[] = ['loc' => $article->path(), 'lastmod' => $article->lastModified()];
        }

        return array_map(fn (array $e): array => ['loc' => $this->absolute($e['loc']), 'lastmod' => $e['lastmod']], $entries);
    }

    private function markdownAlternate(Article $article): string
    {
        return "---\n" . Yaml::dump($article->frontMatter, 4, 2) . "---\n\n" . $article->source;
    }
}
