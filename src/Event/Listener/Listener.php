<?php
declare(strict_types=1);

namespace LessDomain\Event\Listener;

use LessDomain\Event\Event;

interface Listener
{
    public function handle(Event $event): void;
}
