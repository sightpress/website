<?php

declare(strict_types=1);

namespace SightPress\Website\Markdown;

final readonly class RenderedMarkdown
{
    /**
     * @param list<string> $problems accessibility problems found in the text, one sentence each
     */
    public function __construct(
        public string $title,
        public string $html,
        public int $words,
        public array $problems,
    ) {
    }
}
