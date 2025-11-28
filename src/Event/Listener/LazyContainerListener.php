<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener;

use Override;
use LesDomain\Event\Event;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class LazyContainerListener implements Listener
{
    private ?Listener $proxiedListener = null;

    public function __construct(
        private readonly ContainerInterface $container,
        private readonly string $name,
    ) {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Override]
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
