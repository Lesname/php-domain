<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener\Helper;

use LesDomain\Event\Event;

/**
 * @phpstan-ignore trait.unused
 */
trait DelegateActionListenerHelper
{
    public function handle(Event $event): void
    {
        $subHandle = 'handle' . ucfirst((string)$event->action);

        $this->{$subHandle}($event);
    }
}
