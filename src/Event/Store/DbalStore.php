<?php
declare(strict_types=1);

namespace LessDomain\Event\Store;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use JsonException;
use LessDomain\Event\Event;
use LessDomain\Event\Publisher\Publisher;

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
                    'target' => $event->getTarget(),
                    'action' => $event->getAction(),
                    'parameters' => json_encode($event->getParameters(), JSON_THROW_ON_ERROR),
                    'occurred_on' => $event->getOccuredOn(),
                    'headers' => json_encode($event->getHeaders(), JSON_THROW_ON_ERROR),
                ],
            )
            ->executeStatement();
    }
}
