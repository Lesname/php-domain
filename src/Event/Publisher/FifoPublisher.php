<?php
declare(strict_types=1);

namespace LesDomain\Event\Publisher;

use Override;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\Listener;

/**
 * @deprecated use FiberPublisher instead, no guarantees on the order of the listeners
 */
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
    #[Override]
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    #[Override]
    public function publish(Event $event): void
    {
        foreach (($this->subscriptions[$event::class] ?? []) as $listener) {
            $listener->handle($event);
        }
    }
}
