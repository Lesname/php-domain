<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener;

use Override;
use LesDomain\Event\Event;

/**
 * @psalm-mutable
 */
abstract class AbstractDelegateListener implements Listener
{
    /**
     * @psalm-impure
     */
    #[Override]
    public function handle(Event $event): void
    {
        $subHandle = 'handle' . ucfirst((string)$event->action);

        $this->{$subHandle}($event);
    }
}
