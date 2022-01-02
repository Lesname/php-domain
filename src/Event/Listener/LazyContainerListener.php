<?php
declare(strict_types=1);

namespace LessDomain\Event\Listener;

use LessDomain\Event\Event;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class LazyContainerListener implements Listener
{
    private ?Listener $proxiedListener = null;

    public function __construct(private ContainerInterface $container, private string $name)
    {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Event $event): void
    {
        if ($this->proxiedListener === null) {
            $listener = $this->container->get($this->name);
            assert($listener instanceof Listener, 'Expected listener');

            $this->proxiedListener = $listener;
        }

        $this->proxiedListener->handle($event);
    }
}
