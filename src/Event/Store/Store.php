<?php
declare(strict_types=1);

namespace LesDomain\Event\Store;

use LesDomain\Event\Event;

interface Store
{
    public function persist(Event $event): void;
}
