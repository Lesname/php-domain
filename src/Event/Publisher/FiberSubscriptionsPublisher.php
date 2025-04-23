<?php
declare(strict_types=1);

namespace LesDomain\Event\Publisher;

use Fiber;
use Override;
use Throwable;
use LesDomain\Event\Event;

/**
 * @psalm-immutable
 */
final class FiberSubscriptionsPublisher extends AbstractSubscriptionsListener
{
    /**
     * @throws Throwable
     */
    #[Override]
    public function publish(Event $event): void
    {
        $fibers = [];

        foreach ($this->getListenersForEvent($event) as $listener) {
            $fibers[] = new Fiber(fn () => $listener->handle($event));
        }

        do {
            foreach ($fibers as $key => $fiber) {
                if (!$fiber->isStarted()) {
                    $fiber->start();
                } elseif ($fiber->isSuspended()) {
                    $fiber->resume();
                }

                if ($fiber->isTerminated()) {
                    unset($fibers[$key]);
                }
            }
        } while (count($fibers));
    }
}
