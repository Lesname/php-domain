<?php
declare(strict_types=1);

namespace LessDomain\Event;

use LessValueObject\Composite\CompositeValueObject;
use LessValueObject\Number\Int\Date\MilliTimestamp;

/**
 * @psalm-immutable
 */
interface Event extends CompositeValueObject
{
    public function getTarget(): Property\Target;

    public function getAction(): Property\Action;

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array;

    public function getOccuredOn(): MilliTimestamp;

    public function getHeaders(): Property\Headers;
}
