<?php
declare(strict_types=1);

namespace LessDomainTest\Event;

use LessDomain\Event\AbstractEvent;
use LessDomain\Event\Property\Action;
use LessDomain\Event\Property\Headers;
use LessDomain\Event\Property\Target;
use LessValueObject\Number\Int\Date\MilliTimestamp;
use LessValueObject\String\Format\Resource\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Event\AbstractEvent
 */
final class AbstractEventTest extends TestCase
{
    public function testGetters(): void
    {
        $id = new Id('33793b65-ce94-4c9f-80f5-bd26ecc78d25');
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $e = $this->getMockForAbstractClass(
            AbstractEvent::class,
            [$on, $headers],
        );

        self::assertSame($on, $e->getOccuredOn());
        self::assertSame($headers, $e->getHeaders());
    }

    public function testParameters(): void
    {
        $id = new Id('33793b65-ce94-4c9f-80f5-bd26ecc78d25');
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $e = new class ($id, $on, $headers) extends AbstractEvent {
            public function __construct(public Id $id, MilliTimestamp $occurredOn, Headers $headers)
            {
                parent::__construct($occurredOn, $headers);
            }

            public function getTarget(): Target
            {
                return new Target('fiz');
            }

            public function getAction(): Action
            {
                return new Action('bar');
            }
        };

        self::assertSame(
            ['id' => $id],
            $e->getParameters(),
        );
    }

    public function testJson(): void
    {
        $id = new Id('33793b65-ce94-4c9f-80f5-bd26ecc78d25');
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $e = new class ($id, $on, $headers) extends AbstractEvent {
            public function __construct(public Id $id, MilliTimestamp $occurredOn, Headers $headers)
            {
                parent::__construct($occurredOn, $headers);
            }

            public function getTarget(): Target
            {
                return new Target('fiz');
            }

            public function getAction(): Action
            {
                return new Action('bar');
            }
        };

        self::assertEquals(
            [
                'target' => new Target('fiz'),
                'action' => new Action('bar'),
                'parameters' => ['id' => $id],
                'occurredOn' => $on,
                'headers' => $headers,
            ],
            $e->jsonSerialize(),
        );
    }
}
