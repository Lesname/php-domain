<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Publisher;

use LesDomain\Event\AbstractAggregateEvent;
use LesDomain\Event\AbstractEvent;
use LesDomain\Event\Listener\LazyContainerListener;
use LesDomain\Event\Publisher\FifoPublisher;
use LesDomain\Event\Publisher\FifoPublisherFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \LesDomain\Event\Publisher\FifoPublisherFactory
 */
final class FifoPublisherFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $config = [
            FifoPublisherFactory::CONFIG_KEY => [
                LazyContainerListener::class => [
                    AbstractEvent::class,
                    AbstractAggregateEvent::class,
                ],
            ],
        ];

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects(self::once())
            ->method('get')
            ->with('config')
            ->willReturn($config);

        $factory = new FifoPublisherFactory();

        $publisher = $factory($container);
        self::assertInstanceOf(FifoPublisher::class, $publisher);

        self::assertEquals(
            [
                AbstractEvent::class => [
                    new LazyContainerListener($container, LazyContainerListener::class),
                ],
                AbstractAggregateEvent::class => [
                    new LazyContainerListener($container, LazyContainerListener::class),
                ],
            ],
            $publisher->getSubscriptions(),
        );
    }
}
