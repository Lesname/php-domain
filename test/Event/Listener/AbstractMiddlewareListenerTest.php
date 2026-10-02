<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener;

use LesDomain\Event\Event;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use LesDomain\Event\Listener\AbstractMiddlewareListener;
use LesDomain\Event\Listener\Middleware\Handler\MiddlewareHandler;

#[CoversClass(AbstractMiddlewareListener::class)]
class AbstractMiddlewareListenerTest extends TestCase
{
    public function testHandleExecutesMiddleware(): void
    {
        $event = $this->createMock(Event::class);

        $called = 0;
        $stack = 0;

        $handler1 = $this->createMock(MiddlewareHandler::class);
        $handler1
            ->expects($this->once())
            ->method('handle')
            ->willReturnCallback(
                static function ($event, callable $next) use (&$called, &$stack) {
                    self::assertSame(0, $called);
                    self::assertSame(0, $stack);

                    $called += 1;
                    $stack += 1;

                    $next($event);

                    $stack -= 1;
                }
            );

        $handler2 = $this->createMock(MiddlewareHandler::class);
        $handler2
            ->expects($this->once())
            ->method('handle')
            ->willReturnCallback(
                function ($event, callable $next) use (&$called, &$stack) {
                    self::assertSame(1, $called);
                    self::assertSame(1, $stack);

                    $called += 1;
                    $stack += 1;

                    $next($event);

                    $stack -= 1;
                }
            );

        $listener = new class ([$handler1, $handler2]) extends AbstractMiddlewareListener {
            public function __construct(private readonly array $handlers)
            {}

            protected function getHandlers(): array
            {
                return $this->handlers;
            }
        };

        $listener->handle($event);

        self::assertSame(2, $called);
        self::assertSame(0, $stack);
    }
}
