<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Listener\Helper;

use LesDomain\Event\Event;
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

        $event = $this->createMock(Event::class);
        $event
            ->method('getAction')
            ->willReturn($action);

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
