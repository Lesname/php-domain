<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener;

use LesDomain\Event\Event;
use LesDomain\Event\Property\Action;
use LesDomain\Event\Property\Target;
use LesDomain\Event\Property\Headers;
use LesValueObject\Number\Int\Date\MilliTimestamp;
use LesDomain\Event\Listener\AbstractDelegateListener;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractDelegateListener::class)]
class AbstractDelegateListenerTest extends TestCase
{
    public function testDelegates(): void
    {
        $class = new class extends AbstractDelegateListener {
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
}
