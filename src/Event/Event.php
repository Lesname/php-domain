<?php

declare(strict_types=1);

namespace LesDomain\Event;

use LesDomain\Event\Property\Action;
use LesDomain\Event\Property\Headers;
use LesDomain\Event\Property\Target;
use LesValueObject\Composite\CompositeValueObject;
use LesValueObject\Number\Int\Date\MilliTimestamp;

/**
 * @psalm-immutable
 */
interface Event extends CompositeValueObject
{
    public Target $target { get; }
    public Action $action { get; }

    public MilliTimestamp $occurredOn { get; }
    public Headers $headers { get; }

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array;
}
