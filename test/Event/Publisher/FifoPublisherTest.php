<?php
declare(strict_types=1);

namespace LessDomainTest\Event\Publisher;

use ArrayIterator;
use LessDomain\Event\Event;
use LessDomain\Event\Listener\Listener;
use LessDomain\Event\Publisher\FifoPublisher;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Event\Publisher\FifoPublisher
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
}
