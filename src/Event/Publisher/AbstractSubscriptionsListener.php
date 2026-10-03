<?php

declare(strict_types=1);

namespace LesDomain\Event\Publisher;

use Override;
use LesDomain\Event\Event;
use LesDomain\Event\Listener\Listener;

/**
 * @psalm-mutable
 */
abstract class AbstractSubscriptionsListener implements Publisher
{
    /**
     * @param array<class-string<Event>, array<Listener>> $subscriptions
     *
     * @psalm-pure
     */
    final public function __construct(private readonly array $subscriptions)
    {}

    /**
     * @return array<class-string<Event>, array<Listener>>
     */
    #[Override]
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    /**
     * @return iterable<Listener>
     *
     * @psalm-capabilities read-props
     */
    protected function getListenersForEvent(Event $event): iterable
    {
        return $this->subscriptions[$event::class] ?? [];
    }
}
