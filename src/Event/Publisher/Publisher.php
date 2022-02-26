<?php
declare(strict_types=1);

namespace LessDomain\Event\Publisher;

use LessDomain\Event\Event;
use LessDomain\Event\Listener\Listener;

interface Publisher
{
    public function publish(Event $event): void;

    /**
     * @return array<class-string<Event>, array<Listener>>
     */
    public function getSubscriptions(): array;
}
