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
    public function getTarget(): Target;

    public function getAction(): Action;

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array;

    /**
     * @deprecated use getOccurredOn
     */
    public function getOccuredOn(): MilliTimestamp;

    public function getOccurredOn(): MilliTimestamp;

    public function getHeaders(): Headers;
}
