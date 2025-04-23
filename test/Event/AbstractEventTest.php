<?php
declare(strict_types=1);

namespace LesDomainTest\Event;

use LesDomain\Event\AbstractEvent;
use LesDomain\Event\Property\Action;
use LesDomain\Event\Property\Headers;
use LesDomain\Event\Property\Target;
use LesValueObject\Number\Int\Date\MilliTimestamp;
use LesValueObject\String\Format\Resource\Identifier;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\AbstractEvent
 */
final class AbstractEventTest extends TestCase
{
    public function testParameters(): void
    {
        $id = new Identifier('33793b65-ce94-4c9f-80f5-bd26ecc78d25');
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $e = new class ($id, $on, $headers) extends AbstractEvent {
            public function __construct(public Identifier $id, MilliTimestamp $occurredOn, Headers $headers)
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
        $id = new Identifier('33793b65-ce94-4c9f-80f5-bd26ecc78d25');
        $on = MilliTimestamp::now();
        $headers = new Headers();

        $e = new class ($id, $on, $headers) extends AbstractEvent {
            public function __construct(public Identifier $id, MilliTimestamp $occurredOn, Headers $headers)
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
