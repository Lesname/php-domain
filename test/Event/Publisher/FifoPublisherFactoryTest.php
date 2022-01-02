<?php
declare(strict_types=1);

namespace LessDomainTest\Event\Publisher;

use LessDomain\Event\AbstractEvent;
use LessDomain\Event\Publisher\FifoPublisher;
use LessDomain\Event\Publisher\FifoPublisherFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \LessDomain\Event\Publisher\FifoPublisherFactory
 */
final class FifoPublisherFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $config = [
            FifoPublisherFactory::CONFIG_KEY => [
                AbstractEvent::class => [
                    'fiz',
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

        self::assertInstanceOf(FifoPublisher::class, $factory($container));
    }
}
