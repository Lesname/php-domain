<?php

declare(strict_types=1);

namespace LesDomainTest\Event\Store;

use Doctrine\DBAL\Connection;
use LesDomain\Event\AbstractEvent;
use Doctrine\DBAL\Query\QueryBuilder;
use LesDomain\Event\Property\Action;
use LesDomain\Event\Property\Headers;
use LesDomain\Event\Property\Target;
use LesDomain\Event\Publisher\Publisher;
use LesDomain\Event\Store\DbalStore;
use LesValueObject\Number\Int\Date\MilliTimestamp;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\Store\DbalStore
 */
final class DbalStoreTest extends TestCase
{
    public function testPersist(): void
    {
        $target = new Target('fiz');
        $action = new Action('bar');
        $parameters = ['foo' => 'biz'];
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $event = new class ($on, $headers) extends AbstractEvent
        {
            // phpcs:ignore
            public Action $action {
                get {
                    // phpcs:ignore
                    return $this->getAction();
                }
            }
            // phpcs:ignore
            public Target $target {
                get {
                    // phpcs:ignore
                    return $this->getTarget();
                }
            }

            public function getTarget(): Target
            {
                return new Target('fiz');
            }

            public function getAction(): Action
            {
                return new Action('bar');
            }

            public function getParameters(): array
            {
                return ['foo' => 'biz'];
            }
        };

        $builder = $this->createMock(QueryBuilder::class);
        $builder
            ->expects(self::once())
            ->method('insert')
            ->with('event_store')
            ->willReturn($builder);

        $builder
            ->expects(self::once())
            ->method('values')
            ->with(
                [
                    'target' => ':target',
                    'action' => ':action',
                    'parameters' => ':parameters',
                    'occurred_on' => ':occurred_on',
                    'headers' => ':headers',
                ],
            )
            ->willReturn($builder);

        $builder
            ->expects(self::once())
            ->method('setParameters')
            ->with(
                [
                    'target' => $target,
                    'action' => $action,
                    'parameters' => json_encode($parameters),
                    'occurred_on' => $on,
                    'headers' => json_encode($headers),
                ],
            )
            ->willReturn($builder);

        $connection = $this->createMock(Connection::class);
        $connection
            ->expects(self::once())
            ->method('createQueryBuilder')
            ->willReturn($builder);

        $publisher = $this->createMock(Publisher::class);
        $publisher
            ->expects(self::once())
            ->method('publish')
            ->with($event);

        $store = new DbalStore($connection, $publisher);
        $store->persist($event);
    }
}
