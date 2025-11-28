<?php

declare(strict_types=1);

namespace LesDomain\Event;

use LesDomain\Event\Property\Headers;
use LesValueObject\Number\Int\Date\MilliTimestamp;
use LesValueObject\String\Format\Resource\Identifier;

/**
 * @psalm-immutable
 */
abstract class AbstractAggregateEvent extends AbstractEvent
{
    public function __construct(
        public readonly Identifier $id,
        MilliTimestamp $occurredOn,
        Headers $headers,
    ) {
        parent::__construct($occurredOn, $headers);
    }
}
