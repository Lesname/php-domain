<?php
declare(strict_types=1);

namespace LessDomain\Event\Publisher;

use LessDomain\Event\Event;
use LessDomain\Event\Listener\LazyContainerListener;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class FifoPublisherFactory
{
    public const CONFIG_KEY = 'eventSubscriptions';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @psalm-suppress MixedAssignment from foreach
     */
    public function __invoke(ContainerInterface $container): FifoPublisher
    {
        $config = $container->get('config');
        assert(is_array($config), 'Expected array');
        assert(is_array($config[self::CONFIG_KEY]), 'Expected array');

        return new FifoPublisher(
            (function (array $subscriptions) use ($container): iterable {
                foreach ($subscriptions as $event => $listeners) {
                    assert(is_string($event) && is_subclass_of($event, Event::class), 'Expected event class string');
                    assert(is_iterable($listeners), 'Expected listeners');

                    yield $event => (function (iterable $listeners) use ($container): iterable {
                        foreach ($listeners as $listener) {
                            assert(is_string($listener), 'Expected a string');

                            yield new LazyContainerListener($container, $listener);
                        }
                    })($listeners);
                }
            })($config[self::CONFIG_KEY]),
        );
    }
}
