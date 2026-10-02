<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener;

use Override;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\Middleware\Handler\MiddlewareHandler;

abstract class AbstractMiddlewareListener implements Listener
{
    #[Override]
    public function handle(Event $event): void
    {
        $handlers = $this->getHandlers();

        $next = static function (): void {};

        foreach (array_reverse($handlers) as $handler) {
            $next = static function (Event $event) use ($handler, $next): void {
                $handler->handle($event, $next);
            };
        }

        $next($event);
    }

    /**
     * @return array<MiddlewareHandler>
     *
     * @psalm-external-mutation-free
     */
    abstract protected function getHandlers(): array;
}
