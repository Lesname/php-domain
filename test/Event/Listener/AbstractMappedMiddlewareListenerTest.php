<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener;

use Override;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\AbstractMappedMiddlewareListener;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractMappedMiddlewareListener::class)]
class AbstractMappedMiddlewareListenerTest extends TestCase
{
    public function testHandles(): void
    {
        $class = new class extends AbstractMappedMiddlewareListener {
            #[Override]
            protected function getHandlersMap(): array
            {
                return [
                    'foo' => static function (): void {},
                    'bar' => static function (): void {},
                ];
            }
        };

        $this->assertSame(['foo', 'bar'], $class::handles());
    }

    public function testHandleExecutesMappedHandler(): void
    {
        $mockEvent = $this->createMock(Event::class);

        $class = new class ($mockEvent) extends AbstractMappedMiddlewareListener {
            public ?Event $handled = null;

            public function __construct(private readonly Event $handleEvent)
            {}

            #[Override]
            protected function getHandlersMap(): array
            {
                $map = [];
                $map[$this->handleEvent::class] = function (Event $event): void {
                    $this->handled = $event;
                };

                return $map;
            }
        };

        $this->assertSame(null, $class->handled);
        $class->handle($mockEvent);
        $this->assertSame($mockEvent, $class->handled);
    }
}
