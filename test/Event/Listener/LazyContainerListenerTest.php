<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Listener;

use LesDomain\Event\Event;
use LesDomain\Event\Listener\LazyContainerListener;
use LesDomain\Event\Listener\Listener;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \LesDomain\Event\Listener\LazyContainerListener
 */
final class LazyContainerListenerTest extends TestCase
{
    public function testProxy(): void
    {
        $event = $this->createMock(Event::class);

        $realListener = $this->createMock(Listener::class);
        $realListener
            ->expects(self::exactly(2))
            ->method('handle')
            ->with($event);

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects(self::once())
            ->method('get')
            ->with('foo')
            ->willReturn($realListener);

        $proxy = new LazyContainerListener($container, 'foo');

        $proxy->handle($event);
        $proxy->handle($event);
    }
}
