<?php

declare(strict_types=1);

namespace LesDomain\Event\Publisher;

use LesDomain\Event\Event;
use LesDomain\Event\Listener\Listener;

/**
 * @psalm-mutable
 */
interface Publisher
{
    /**
     * @psalm-impure
     */
    public function publish(Event $event): void;

    /**
     * @deprecated
     *
     * @return array<class-string<Event>, array<Listener>>
     *
     * @psalm-capabilities read-props
     */
    public function getSubscriptions(): array;
}
