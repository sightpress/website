<?php

declare(strict_types=1);

namespace SightPress\Website;

/**
 * One article, read from its Markdown file and rendered.
 */
final readonly class Article
{
    /**
     * @param list<string> $tags     tag slugs, in the order the author listed them
     * @param list<string> $copies   addresses of copies on other sites, each linking back here
     * @param array<string, mixed> $frontMatter the normalised front matter, written to the Markdown alternate
     */
    public function __construct(
        public string $slug,
        public string $title,
        public string $section,
        public array $tags,
        public string $status,
        public string $published,
        public ?string $updated,
        public string $description,
        public ?string $image,
        public ?string $imageAlt,
        public array $copies,
        public string $html,
        public int $words,
        public string $source,
        public array $frontMatter,
    ) {
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function path(): string
    {
        return '/articles/' . $this->slug . '/';
    }

    /** The date of the last change: `updated` when set, otherwise `published`. */
    public function lastModified(): string
    {
        return $this->updated ?? $this->published;
    }

    /** Minutes to read at about 200 words a minute, at least 1. */
    public function readingMinutes(): int
    {
        return max(1, (int) ceil($this->words / 200));
    }
}
