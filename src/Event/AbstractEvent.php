<?php
declare(strict_types=1);

namespace LessDomain\Event;

use LessValueObject\Number\Int\Date\MilliTimestamp;

/**
 * @psalm-immutable
 */
abstract class AbstractEvent implements Event
{
    public function __construct(
        private readonly MilliTimestamp $occurredOn,
        private readonly Property\Headers $headers,
    ) {}

    public function getOccuredOn(): MilliTimestamp
    {
        return $this->occurredOn;
    }

    public function getHeaders(): Property\Headers
    {
        return $this->headers;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array
    {
        $parameters = get_object_vars($this);
        unset($parameters['occurredOn'], $parameters['headers']);

        return $parameters;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'target' => $this->getTarget(),
            'action' => $this->getAction(),
            'parameters' => $this->getParameters(),
            'occurredOn' => $this->getOccuredOn(),
            'headers' => $this->getHeaders(),
        ];
    }
}
