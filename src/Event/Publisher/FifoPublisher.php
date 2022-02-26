<?php
declare(strict_types=1);

namespace LessDomain\Event\Publisher;

use LessDomain\Event\Event;
use LessDomain\Event\Listener\Listener;

final class FifoPublisher implements Publisher
{
    /**
     * @param array<class-string<Event>, array<Listener>> $subscriptions
     */
    public function __construct(private readonly array $subscriptions)
    {}

    /**
     * @return array<class-string<Event>, array<Listener>>
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function publish(Event $event): void
    {
        foreach (($this->subscriptions[$event::class] ?? []) as $listener) {
            $listener->handle($event);
        }
    }
}
