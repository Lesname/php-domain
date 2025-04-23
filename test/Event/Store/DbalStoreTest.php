<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Store;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use LesDomain\Event\Event;
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

        $event = $this->createMock(Event::class);
        $event->method('getTarget')->willReturn($target);
        $event->method('getAction')->willReturn($action);
        $event->method('getParameters')->willReturn($parameters);
        $event->method('getOccuredOn')->willReturn($on);
        $event->method('getheaders')->willReturn($headers);

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
