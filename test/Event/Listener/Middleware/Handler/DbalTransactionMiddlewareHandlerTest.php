<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener\Middleware\Handler;

use LesDomain\Event\Event;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use LesDomain\Event\Listener\Middleware\Handler\DbalTransactionMiddlewareHandler;

#[CoversClass(DbalTransactionMiddlewareHandler::class)]
class DbalTransactionMiddlewareHandlerTest extends TestCase
{
    public function testHandleCommitsTransactionOnSuccess(): void
    {
        $db = $this->createMock(Connection::class);
        $db->expects($this->once())->method('beginTransaction');
        $db->expects($this->once())->method('commit');
        $db->expects($this->never())->method('rollBack');

        $handler = new DbalTransactionMiddlewareHandler($db);

        $event = $this->createMock(Event::class);
        $next = fn($receivedEvent) => $this->assertSame($event, $receivedEvent);

        $handler->handle($event, $next);
    }

    public function testHandleRollsBackTransactionOnException(): void
    {
        $db = $this->createMock(Connection::class);
        $db->expects($this->once())->method('beginTransaction');
        $db->expects($this->never())->method('commit');
        $db->expects($this->once())->method('rollBack');

        $handler = new DbalTransactionMiddlewareHandler($db);

        $event = $this->createMock(Event::class);
        $next = function () {
            throw new \RuntimeException('Test exception');
        };

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Test exception');

        $handler->handle($event, $next);
    }
}
