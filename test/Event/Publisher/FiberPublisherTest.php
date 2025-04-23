<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Publisher;

use Fiber;
use Override;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\Listener;
use LesDomain\Event\Publisher\FiberSubscriptionsPublisher;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\Publisher\FiberSubscriptionsPublisher
 */
class FiberPublisherTest extends TestCase
{
    public function testPublish(): void
    {
        $event = $this->createMock(Event::class);

        $counter = (object)['count' => 0];

        $firstListener = new class ($counter) implements Listener {
            public function __construct(public readonly object $counter)
            {
            }

            #[Override]
            public function handle(Event $event): void
            {
                Fiber::suspend();

                $this->counter->count++;
            }
        };

        $secondListener = new class ($counter) implements Listener {
            public function __construct(public readonly object $counter)
            {
            }

            #[Override]
            public function handle(Event $event): void
            {
                $this->counter->count++;
            }
        };

        $publisher = new FiberSubscriptionsPublisher(
            [
                $event::class => [
                    $firstListener,
                    $secondListener,
                ],
            ],
        );

        $publisher->publish($event);

        self::assertSame(2, $counter->count);
    }
}
