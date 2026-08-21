<?php

declare(strict_types=1);

namespace LesDomain\Event\Store;

use LesDomain\Event\Event;

/**
 * @psalm-mutable
 */
interface Store
{
    /**
     * @psalm-impure
     */
    public function persist(Event $event): void;
}
