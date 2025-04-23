<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Publisher;

use ArrayIterator;
use LesDomain\Event\AbstractEvent;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\Listener;
use LesDomain\Event\Publisher\FifoPublisher;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\Publisher\FifoPublisher
 */
final class FifoPublisherTest extends TestCase
{
    public function testPublish(): void
    {
        $event = $this->createMock(Event::class);

        $notUsedListener = $this->createMock(Listener::class);

        $firstUsedListener = $this->createMock(Listener::class);
        $firstUsedListener
            ->expects(self::once())
            ->method('handle')
            ->with($event);

        $secUsedListener = $this->createMock(Listener::class);
        $secUsedListener
            ->expects(self::once())
            ->method('handle')
            ->with($event);

        $publisher = new FifoPublisher(
            [
                $event::class => [
                    $firstUsedListener,
                    $secUsedListener,
                ],
                Event::class => new ArrayIterator(
                    [$notUsedListener],
                ),
            ],
        );

        $publisher->publish($event);
    }

    public function testGetSubscriptions(): void
    {
        $listener = $this->createMock(Listener::class);

        $subs = [AbstractEvent::class => [$listener]];

        $publisher = new FifoPublisher($subs);

        self::assertSame($subs, $publisher->getSubscriptions());
    }
}
