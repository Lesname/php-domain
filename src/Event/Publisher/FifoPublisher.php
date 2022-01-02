<?php
declare(strict_types=1);

namespace LessDomain\Event\Publisher;

use LessDomain\Event\Event;
use LessDomain\Event\Listener\Listener;
use Traversable;

final class FifoPublisher implements Publisher
{
    /** @var array<class-string<Event>, array<Listener>> */
    private array $subscriptions = [];

    /**
     * @param iterable<class-string<Event>, iterable<Listener>> $subscriptions
     */
    public function __construct(iterable $subscriptions)
    {
        foreach ($subscriptions as $event => $listeners) {
            $listeners = $listeners instanceof Traversable
                ? iterator_to_array($listeners)
                : $listeners;

            $this->subscriptions[$event] = $listeners;
        }
    }

    public function publish(Event $event): void
    {
        foreach (($this->subscriptions[$event::class] ?? []) as $listener) {
            $listener->handle($event);
        }
    }
}
