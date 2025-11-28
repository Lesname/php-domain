<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener\Helper;

use LesDomain\Event\Event;
use LesDomain\Event\AbstractEvent;
use LesDomain\Event\Property\Target;
use LesDomain\Event\Property\Headers;
use LesValueObject\Number\Int\Date\MilliTimestamp;
use LesDomain\Event\Listener\Helper\DelegateActionListenerHelper;
use LesDomain\Event\Property\Action;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\Listener\Helper\DelegateActionListenerHelper
 */
final class DelegateActionListenerHelperTest extends TestCase
{
    public function testSubHandle(): void
    {
        $action = new Action('foo');

        $event = new class ($action) implements Event {
            public Target $target;

            public MilliTimestamp $occurredOn;
            public Headers $headers;

            public function __construct(public Action $action)
            {
                $this->target = new Target('fiz');
                $this->occurredOn = new MilliTimestamp(1);
                $this->headers = new Headers();
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

        $class = new class ($this, $event) {
            use DelegateActionListenerHelper;

            public function __construct(private TestCase $tester, private Event $event)
            {}

            private function handleFoo(Event $event)
            {
                $this->tester::assertSame($this->event, $event);
            }
        };

        $class->handle($event);
    }
}
