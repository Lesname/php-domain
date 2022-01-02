<?php
declare(strict_types=1);

namespace LessDomain\Event\Store;

use LessDomain\Event\Event;

interface Store
{
    public function persist(Event $event): void;
}
