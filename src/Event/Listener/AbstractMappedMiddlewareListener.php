<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener;

use Override;
use ReflectionClass;
use ReflectionException;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\Middleware\Handler\MappedMiddlewareHandler;

abstract class AbstractMappedMiddlewareListener extends AbstractMiddlewareListener
{
    /**
     * @psalm-external-mutation-free
     */
    #[Override]
    protected function getHandlers(): array
    {
        return [new MappedMiddlewareHandler($this->getHandlersMap())];
    }

    /**
     * @return array<string, callable(Event $event): void>
     *
     * @psalm-external-mutation-free
     */
    abstract protected function getHandlersMap(): array;

    /**
     * @throws ReflectionException
     *
     * @return array<string>
     */
    public static function handles(): array
    {
        $ref = new ReflectionClass(static::class);
        $class = $ref->newInstanceWithoutConstructor();

        return array_keys($class->getHandlersMap());
    }
}
