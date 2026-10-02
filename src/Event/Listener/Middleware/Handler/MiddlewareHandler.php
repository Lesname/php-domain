<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener\Middleware\Handler;

use LesDomain\Event\Event;

/**
 * @psalm-mutable
 */
interface MiddlewareHandler
{
    /**
     * @param callable(Event $event): void $next
     *
     * @psalm-impure
     */
    public function handle(Event $event, callable $next): void;
}
