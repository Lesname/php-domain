<?php
declare(strict_types=1);

namespace LessDomain\Event\Publisher;

use LessDomain\Event\Event;

interface Publisher
{
    public function publish(Event $event): void;
}
