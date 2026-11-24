<?php

declare(strict_types=1);

namespace SightPress\Website;

use SightPress\Website\Markdown\MarkdownRenderer;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Reads articles either from the private drafts folder (files named `YYYY-MM-DD-slug.md`) or, when that folder isn't
 * available, from the Markdown copies of published articles that the build commits next to each page
 * (`public/articles/<slug>/index.md`). Both give the same result, so anyone can rebuild the site without the drafts.
 */
final class ArticleLoader
{
    private const array KNOWN_KEYS = [
        'title', 'section', 'tags', 'status', 'published', 'updated', 'description', 'slug', 'image', 'image_alt',
        'copies', 'author', 'canonical',
    ];

    /** @var list<string> */
    private array $warnings = [];

    /**
     * @param list<string> $sections
     * @param array<string, string> $tags
     */
    public function __construct(
        private readonly MarkdownRenderer $markdown,
        private readonly array $sections,
        private readonly array $tags,
        private readonly string $siteUrl,
    ) {
    }

    /**
     * Problems found in drafts. They don't stop the build, because drafts are never published.
     *
     * @return list<string>
     */
    public function warnings(): array
    {
        return $this->warnings;
    }

    /**
     * @return list<Article> newest first
     */
    public function fromDrafts(string $directory, bool $includeDrafts): array
    {
        $files = glob(rtrim($directory, '/') . '/[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]-*.md') ?: [];
        $articles = [];
        $problems = [];
        foreach ($files as $file) {
            if (preg_match('/^(\d{4}-\d{2}-\d{2})-(.+)\.md$/', basename($file), $match) !== 1) {
                continue;
            }
            try {
                $article = $this->load($file, $match[1], $match[2]);
            } catch (BuildError $error) {
                $problems = [...$problems, ...$error->problems];
                continue;
            }
            if ($article->isPublished() || $includeDrafts) {
                $articles[] = $article;
            }
        }
        if ($problems !== []) {
            throw new BuildError($problems);
        }

        return $this->sorted($articles);
    }

    /**
     * @return list<Article> newest first
     */
    public function fromPublished(string $articlesDirectory): array
    {
        $articles = [];
        $problems = [];
        foreach (glob(rtrim($articlesDirectory, '/') . '/*/index.md') ?: [] as $file) {
            try {
                $article = $this->load($file, null, basename(\dirname($file)));
            } catch (BuildError $error) {
                $problems = [...$problems, ...$error->problems];
                continue;
            }
            $articles[] = $article;
        }
        if ($problems !== []) {
            throw new BuildError($problems);
        }

        return $this->sorted($articles);
    }

    private function load(string $file, ?string $fileDate, string $fileSlug): Article
    {
        $name = basename(\dirname($file)) . '/' . basename($file);
        $content = str_replace("\r\n", "\n", (string) file_get_contents($file));
        if (preg_match('/\A---\n(.*?)\n---\n(.*)\z/s', $content, $parts) !== 1) {
            throw new BuildError(["$name: the file must start with front matter between two --- lines."]);
        }
        try {
            $meta = Yaml::parse($parts[1]);
        } catch (ParseException $exception) {
            throw new BuildError(["$name: the front matter isn't valid YAML: {$exception->getMessage()}"]);
        }
        if (!\is_array($meta)) {
            throw new BuildError(["$name: the front matter must be a list of keys and values."]);
        }
        $body = trim($parts[2]) . "\n";

        $problems = [];
        foreach (array_keys($meta) as $key) {
            if (!\in_array($key, self::KNOWN_KEYS, true)) {
                $problems[] = "unknown front matter key \"$key\"";
            }
        }

        $status = $this->string($meta, 'status') ?? 'draft';
        if (!\in_array($status, ['draft', 'published'], true)) {
            $problems[] = "status must be \"draft\" or \"published\", not \"$status\"";
        }
        $section = $this->string($meta, 'section') ?? '';
        if (!\in_array($section, $this->sections, true)) {
            $problems[] = $section === '' ? 'section is missing' : "unknown section \"$section\" (add it to src/taxonomy.php first)";
        }
        $tags = $meta['tags'] ?? [];
        if (!\is_array($tags) || !array_is_list($tags)) {
            $problems[] = 'tags must be a list';
            $tags = [];
        }
        $tags = array_map('strval', $tags);
        foreach ($tags as $tag) {
            if (!isset($this->tags[$tag])) {
                $problems[] = "unknown tag \"$tag\" (add it to src/taxonomy.php first)";
            }
        }
        $published = $this->date($meta, 'published', $problems) ?? $fileDate;
        if ($published === null) {
            $problems[] = 'published date is missing';
        }
        $updated = $this->date($meta, 'updated', $problems);
        if ($updated !== null && $published !== null && $updated < $published) {
            $problems[] = 'updated is earlier than published';
        }
        $description = $this->string($meta, 'description') ?? '';
        if ($description === '') {
            $problems[] = 'description is missing (one sentence, at most 160 characters)';
        } elseif (mb_strlen($description) > 160) {
            $problems[] = sprintf('description is %d characters long; keep it to 160', mb_strlen($description));
        }
        $slug = $this->string($meta, 'slug') ?? $fileSlug;
        if (preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug) !== 1) {
            $problems[] = "slug \"$slug\" may only use lowercase letters, digits and single hyphens";
        }
        $image = $this->string($meta, 'image');
        $imageAlt = $this->string($meta, 'image_alt');
        if (($image === null) !== ($imageAlt === null)) {
            $problems[] = 'image and image_alt go together: set both or neither';
        }
        $copies = $meta['copies'] ?? [];
        if (!\is_array($copies) || !array_is_list($copies)) {
            $problems[] = 'copies must be a list of addresses';
            $copies = [];
        }
        $copies = array_map('strval', $copies);
        foreach ($copies as $copy) {
            if (preg_match('#^https://\S+$#', $copy) !== 1) {
                $problems[] = "copy address \"$copy\" must start with https://";
            }
        }

        $rendered = $this->markdown->render($body);
        $problems = [...$problems, ...$rendered->problems];

        if ($problems !== []) {
            $lines = array_map(static fn (string $problem): string => "$name: $problem", $problems);
            if ($status === 'published') {
                throw new BuildError($lines);
            }
            $this->warnings = [...$this->warnings, ...$lines];
        }

        $frontMatter = array_filter([
            'title' => $rendered->title,
            'author' => 'Pedro Ferreira',
            'section' => $section,
            'tags' => $tags,
            'status' => $status,
            'published' => $published,
            'updated' => $updated,
            'description' => $description,
            'slug' => $slug,
            'image' => $image,
            'image_alt' => $imageAlt,
            'copies' => $copies,
            'canonical' => $this->siteUrl . '/articles/' . $slug . '/',
        ], static fn (mixed $value): bool => $value !== null && $value !== []);

        return new Article(
            slug: $slug,
            title: $rendered->title,
            section: $section,
            tags: $tags,
            status: $status,
            published: $published ?? '1970-01-01',
            updated: $updated,
            description: $description,
            image: $image,
            imageAlt: $imageAlt,
            copies: $copies,
            html: $rendered->html,
            words: $rendered->words,
            source: $body,
            frontMatter: $frontMatter,
        );
    }

    /**
     * @param array<mixed> $meta
     */
    private function string(array $meta, string $key): ?string
    {
        if (!isset($meta[$key])) {
            return null;
        }
        $value = trim(\is_scalar($meta[$key]) ? (string) $meta[$key] : '');

        return $value === '' ? null : $value;
    }

    /**
     * YAML reads an unquoted date as a timestamp; accept that and a quoted "YYYY-MM-DD".
     *
     * @param array<mixed> $meta
     * @param list<string> $problems
     */
    private function date(array $meta, string $key, array &$problems): ?string
    {
        $value = $meta[$key] ?? null;
        if ($value === null || $value === '') {
            return null;
        }
        if (\is_int($value)) {
            return gmdate('Y-m-d', $value);
        }
        if (\is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1
            && \DateTimeImmutable::createFromFormat('!Y-m-d', $value) !== false) {
            return $value;
        }
        $problems[] = "$key must be a date written as YYYY-MM-DD";

        return null;
    }

    /**
     * @param list<Article> $articles
     *
     * @return list<Article>
     */
    private function sorted(array $articles): array
    {
        $slugs = array_count_values(array_map(static fn (Article $a): string => $a->slug, $articles));
        $duplicates = array_keys(array_filter($slugs, static fn (int $count): bool => $count > 1));
        if ($duplicates !== []) {
            throw new BuildError(array_map(static fn (string $s): string => "Two articles use the slug \"$s\".", $duplicates));
        }
        // Newest first; articles from the same day are ordered by slug, last first.
        usort($articles, static fn (Article $a, Article $b): int => [$b->published, $b->slug] <=> [$a->published, $a->slug]);

        return $articles;
    }
}
