<?php

declare(strict_types=1);

namespace LesDomain\Config;

use LesDomain\Event\Publisher;
use LesDomain\Event\Store;

/**
 * @psalm-immutable
 */
final class ConfigProvider
{
    /**
     * @return array<string, mixed>
     *
     * @psalm-pure
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'aliases' => [
                    Store\Store::class => Store\DbalStore::class,

                    Publisher\Publisher::class => Publisher\FiberSubscriptionsPublisher::class,
                ],
                'factories' => [
                    Store\DbalStore::class => Store\DbalStoreFactory::class,

                    Publisher\FiberSubscriptionsPublisher::class => Publisher\AbstractSubscriptionsPublisherFactory::class,
                ],
            ],
        ];
    }
}
