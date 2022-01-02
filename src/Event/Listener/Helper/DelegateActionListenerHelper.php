<?php
declare(strict_types=1);

namespace LessDomain\Event\Listener\Helper;

use LessDomain\Event\Event;
use LessDomain\Event\Listener\Helper\Exception\RecursiveMethod;

trait DelegateActionListenerHelper
{
    /**
     * @throws RecursiveMethod
     */
    public function handle(Event $event): void
    {
        $subHandle = 'handle' . ucfirst((string)$event->getAction());
        assert($subHandle !== 'handle', new RecursiveMethod());

        $this->{$subHandle}($event);
    }
}
