<?php

namespace LesDomainTest\Event\Listener\Middleware\Handler;

use RuntimeException;
use LesDomain\Event\Event;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use LesDomain\Event\Listener\Middleware\Handler\MappedMiddlewareHandler;

#[CoversClass(MappedMiddlewareHandler::class)]
final class MappedMiddlewareHandlerTest extends TestCase
{
    public function testHandlePassesControlToNextCallable(): void
    {
        $eventMock = $this->createMock(Event::class);

        $calledHandlerWasCalled = 0;
        $calledHandler = function (Event $event) use ($eventMock, &$calledHandlerWasCalled) {
            $this->assertSame($eventMock, $event);
            $calledHandlerWasCalled += 1;
        };

        $uncalledHandlerWasCalled = 0;
        $uncalledHandler = function (Event $event) use ($eventMock, &$uncalledHandlerWasCalled) {
            $this->assertSame($eventMock, $event);
            $uncalledHandlerWasCalled += 1;
        };

        $nextCalled = 0;
        $next = function (Event $event) use ($eventMock, &$nextCalled) {
            $this->assertSame($eventMock, $event);
            $nextCalled += 1;
        };

        new MappedMiddlewareHandler(
            [
                $eventMock::class => $calledHandler,
                'foo' => $uncalledHandler,
            ],
        )->handle($eventMock, $next);

        $this->assertSame(0, $uncalledHandlerWasCalled, 'Uncalled handler should not be executed.');
        $this->assertSame(1, $calledHandlerWasCalled, 'Called handler should be executed.');

        $this->assertSame(1, $nextCalled, 'Next should be called');
    }

    public function testHandleThrowsExceptionIfNoHandlerMapped(): void
    {
        $eventMock = $this->createMock(Event::class);
        $eventClass = $eventMock::class;

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No handler found for event ' . $eventClass);

        new MappedMiddlewareHandler([])->handle($eventMock, static function () {});
    }
}
