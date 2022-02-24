<?php
declare(strict_types=1);

namespace LessDomainTest\Event;

use LessDomain\Event\AbstractAggregateEvent;
use LessDomain\Event\Property\Headers;
use LessValueObject\Number\Int\Date\MilliTimestamp;
use LessValueObject\String\Format\Resource\Identifier;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Event\AbstractAggregateEvent
 */
final class AbstractAggregateEventTest extends TestCase
{
    public function testConstruct(): void
    {
        $id = new Identifier('33793b65-ce94-4c9f-80f5-bd26ecc78d25');
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $e = $this->getMockForAbstractClass(
            AbstractAggregateEvent::class,
            [$id, $on, $headers],
        );

        self::assertSame($id, $e->id);
        self::assertSame($on, $e->getOccuredOn());
        self::assertSame($headers, $e->getHeaders());
    }
}
