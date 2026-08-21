<?php

declare(strict_types=1);

namespace LesDomain\Event\Store;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use LesDomain\Event\Publisher\Publisher;

final class DbalStoreFactory
{
    public function __invoke(ContainerInterface $container): DbalStore
    {
        $connection = $container->get(Connection::class);
        assert($connection instanceof Connection);

        $publisher = $container->get(Publisher::class);
        assert($publisher instanceof Publisher);

        return new DbalStore($connection, $publisher);
    }
}
