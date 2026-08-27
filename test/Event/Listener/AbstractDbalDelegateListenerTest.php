<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener;

use RuntimeException;
use LesDomain\Event\Event;
use Doctrine\DBAL\Connection;
use LesDomain\Event\Property\Target;
use LesDomain\Event\Property\Action;
use LesDomain\Event\Property\Headers;
use LesValueObject\Number\Int\Date\MilliTimestamp;
use LesDomain\Event\Listener\AbstractDbalDelegateListener;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractDbalDelegateListener::class)]
class AbstractDbalDelegateListenerTest extends TestCase
{
    public function testCommit(): void
    {
        $connection = $this->createMock(Connection::class);
        $connection
            ->expects(self::once())
            ->method('beginTransaction');
        $connection
            ->expects(self::once())
            ->method('commit');
        $connection
            ->expects(self::never())
            ->method('rollBack');

        $class = new class ($connection) extends AbstractDbalDelegateListener {
            public ?Event $event = null;

            public function handleFoo(Event $event): void
            {
                $this->event = $event;
            }
        };

        $event = new class implements Event {
            public Target $target;
            public Action $action;

            public Headers $headers;
            public MilliTimestamp $occurredOn;

            public function __construct()
            {
                $this->action = new Action('foo');
                $this->target = new Target('bar');
            }

            #[\Override]
            public function getParameters(): array
            {
            }

            #[\Override]
            public function jsonSerialize(): mixed
            {
            }
        };

        $class->handle($event);

        self::assertSame($event, $class->event);
    }

    public function testRollback(): void
    {
        $this->expectException(\Throwable::class);

        $connection = $this->createMock(Connection::class);
        $connection
            ->expects(self::once())
            ->method('beginTransaction');
        $connection
            ->expects(self::never())
            ->method('commit');
        $connection
            ->expects(self::once())
            ->method('rollBack');

        $class = new class ($connection) extends AbstractDbalDelegateListener {
            public function handleFoo(Event $event): void
            {
                throw new RuntimeException();
            }
        };

        $event = new class implements Event {
            public Target $target;
            public Action $action;

            public Headers $headers;
            public MilliTimestamp $occurredOn;

            public function __construct()
            {
                $this->action = new Action('foo');
                $this->target = new Target('bar');
            }

            #[\Override]
            public function getParameters(): array
            {
            }

            #[\Override]
            public function jsonSerialize(): mixed
            {
            }
        };

        $class->handle($event);
    }
}
