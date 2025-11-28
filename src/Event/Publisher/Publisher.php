<?php

declare(strict_types=1);

namespace LesDomain\Event\Publisher;

use LesDomain\Event\Event;
use LesDomain\Event\Listener\Listener;

/**
 * @psalm-immutable
 */
interface Publisher
{
    public function publish(Event $event): void;

    /**
     * @deprecated
     *
     * @return array<class-string<Event>, array<Listener>>
     */
    public function getSubscriptions(): array;
}
