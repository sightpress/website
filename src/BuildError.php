<?php

declare(strict_types=1);

namespace SightPress\Website;

/**
 * Stops the build with a list of problems, one line each.
 */
final class BuildError extends \RuntimeException
{
    /**
     * @param list<string> $problems
     */
    public function __construct(public readonly array $problems)
    {
        parent::__construct(implode("\n", $problems));
    }
}
