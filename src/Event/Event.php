<?php
declare(strict_types=1);

namespace LessDomain\Event;

use LessDomain\Event\Property\Action;
use LessDomain\Event\Property\Headers;
use LessDomain\Event\Property\Target;
use LessValueObject\Composite\CompositeValueObject;
use LessValueObject\Number\Int\Date\MilliTimestamp;

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

    public function getOccuredOn(): MilliTimestamp;

    public function getHeaders(): Headers;
}
