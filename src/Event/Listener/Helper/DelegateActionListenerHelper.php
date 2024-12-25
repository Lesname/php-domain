<?php
declare(strict_types=1);

namespace LessDomain\Event\Listener\Helper;

use LessDomain\Event\Event;

/**
 * @phpstan-ignore trait.unused
 */
trait DelegateActionListenerHelper
{
    public function handle(Event $event): void
    {
        $subHandle = 'handle' . ucfirst((string)$event->getAction());

        $this->{$subHandle}($event);
    }
}
