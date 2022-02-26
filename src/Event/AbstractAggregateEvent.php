<?php
declare(strict_types=1);

namespace LessDomain\Event;

use LessDomain\Event\Property\Headers;
use LessValueObject\Number\Int\Date\MilliTimestamp;
use LessValueObject\String\Format\Resource\Identifier;

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
