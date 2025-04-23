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
    // phpcs:ignore
    public Target $target { get; }
    // phpcs:ignore
    public Action $action { get; }

    // phpcs:ignore
    public MilliTimestamp $occurredOn { get; }
    // phpcs:ignore
    public Headers $headers { get; }

    /**
     * @deprecated
     */
    public function getTarget(): Target;

    /**
     * @deprecated
     */
    public function getAction(): Action;

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array;

    /**
     * @deprecated
     */
    public function getOccurredOn(): MilliTimestamp;

    /**
     * @deprecated
     */
    public function getHeaders(): Headers;
}
