<?php

declare(strict_types=1);

namespace SightPress\Website\Markdown;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\StringContainerHelper;
use SightPress\Website\Slug;

/**
 * Gives every heading a unique id made from its text, so it can be linked to.
 */
final class HeadingIds
{
    public function __invoke(DocumentParsedEvent $event): void
    {
        $used = [];
        foreach ($event->getDocument()->iterator() as $node) {
            if (!$node instanceof Heading) {
                continue;
            }
            $base = Slug::of(StringContainerHelper::getChildText($node)) ?: 'section';
            $id = $base;
            for ($i = 2; isset($used[$id]); ++$i) {
                $id = $base . '-' . $i;
            }
            $used[$id] = true;
            $node->data->set('attributes/id', $id);
        }
    }
}
