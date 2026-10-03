<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener;

use LesDomain\Event\Event;

/**
 * @psalm-mutable
 */
interface Listener
{
    /**
     * @psalm-impure
     */
    public function handle(Event $event): void;
}
