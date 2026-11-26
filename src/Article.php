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
     * @param ?string      $imageCaption HTML of the caption shown under the image on the page
     * @param ?string      $imageCredit  HTML of the credit shown under the image on the page
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
        public ?string $imageCaption,
        public ?string $imageCredit,
        public array $copies,
        public string $html,
        public int $words,
        public string $source,
        public array $frontMatter,
    ) {
    }

    /** The image is shown on the page only when it has a caption or a credit; otherwise it is only for sharing. */
    public function showsImage(): bool
    {
        return $this->image !== null && ($this->imageCaption !== null || $this->imageCredit !== null);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function path(): string
    {
        return '/blog/' . $this->slug . '/';
    }

    /** The date of the last change: `updated` when set, otherwise `published`. */
    public function lastModified(): string
    {
        return $this->updated ?? $this->published;
    }

    /**
     * Minutes to read at 238 words a minute, the average silent reading speed for English non-fiction
     * (Brysbaert, 2019), rounded to the nearest minute and at least 1.
     */
    public function readingMinutes(): int
    {
        return max(1, (int) round($this->words / 238));
    }
}
