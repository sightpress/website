<?php

declare(strict_types=1);

namespace SightPress\Website;

final class Slug
{
    /** "The blind creator's experience" becomes "the-blind-creators-experience". */
    public static function of(string $text): string
    {
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = strtolower($ascii === false ? $text : $ascii);
        $text = str_replace(["'", '’'], '', $text);
        $text = (string) preg_replace('/[^a-z0-9]+/', '-', $text);

        return trim($text, '-');
    }
}
