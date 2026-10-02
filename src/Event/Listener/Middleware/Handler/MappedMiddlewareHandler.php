<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener\Middleware\Handler;

use Override;
use RuntimeException;
use LesDomain\Event\Event;

final class MappedMiddlewareHandler implements MiddlewareHandler
{
    /**
     * @param array<string, callable(Event $event): void> $mapping
     *
     * @psalm-pure
     */
    public function __construct(private readonly array $mapping)
    {}

    #[Override]
    public function handle(Event $event, callable $next): void
    {
        if (!array_key_exists($event::class, $this->mapping)) {
            throw new RuntimeException('No handler found for event ' . $event::class);
        }

        $handler = $this->mapping[$event::class];
        $handler($event);

        $next($event);
    }
}
