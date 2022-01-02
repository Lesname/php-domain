<?php
declare(strict_types=1);

namespace LessDomain\Event;

use LessValueObject\Number\Int\Date\MilliTimestamp;
use LessValueObject\String\Format\Reference\Id;

/**
 * @psalm-immutable
 */
abstract class AbstractAggregateEvent extends AbstractEvent
{
    public function __construct(
        public Id $id,
        MilliTimestamp $occurredOn,
        Property\Headers $headers,
    ) {
        parent::__construct($occurredOn, $headers);
    }
}
