<?php

declare(strict_types=1);

namespace LesDomain\Event\Store;

use Override;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use JsonException;
use LesDomain\Event\Event;
use LesDomain\Event\Publisher\Publisher;

final class DbalStore implements Store
{
    public function __construct(
        private readonly Connection $connection,
        private readonly Publisher $publisher,
    ) {}

    /**
     * @throws Exception
     * @throws JsonException
     */
    #[Override]
    public function persist(Event $event): void
    {
        $this->insert($event);
        $this->publisher->publish($event);
    }

    /**
     * @throws Exception
     * @throws JsonException
     */
    private function insert(Event $event): void
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->insert('event_store')
            ->values(
                [
                    'target' => ':target',
                    'action' => ':action',
                    'parameters' => ':parameters',
                    'occurred_on' => ':occurred_on',
                    'headers' => ':headers',
                ],
            )
            ->setParameters(
                [
                    'target' => $event->target,
                    'action' => $event->action,
                    'parameters' => json_encode($event->getParameters(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
                    'occurred_on' => $event->occurredOn,
                    'headers' => json_encode($event->headers, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
                ],
            )
            ->executeStatement();
    }
}
