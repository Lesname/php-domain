<?php
declare(strict_types=1);

namespace LesDomain\Event;

use Override;
use LesDomain\Event\Property\Action;
use LesDomain\Event\Property\Target;
use LesDomain\Event\Property\Headers;
use LesValueObject\Number\Int\Date\MilliTimestamp;

/**
 * @psalm-immutable
 */
abstract class AbstractEvent implements Event
{
    // phpcs:ignore
    public Target $target {
        get {
            // phpcs:ignore
            return $this->getTarget();
        }
    }
    // phpcs:ignore
    public Action $action {
        get {
            // phpcs:ignore
            return $this->getAction();
        }
    }

    public function __construct(
        public readonly MilliTimestamp $occurredOn,
        public readonly Headers $headers,
    ) {}

    #[Override]
    public function getOccurredOn(): MilliTimestamp
    {
        return $this->occurredOn;
    }

    #[Override]
    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function getParameters(): array
    {
        $parameters = get_object_vars($this);
        unset(
            $parameters['occurredOn'],
            $parameters['headers'],
            $parameters['action'],
            $parameters['target'],
        );

        return $parameters;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'target' => $this->target,
            'action' => $this->action,
            'parameters' => $this->getParameters(),
            'occurredOn' => $this->occurredOn,
            'headers' => $this->headers,
        ];
    }
}
