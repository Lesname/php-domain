<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener\Middleware\Handler;

use Override;
use Throwable;
use LesDomain\Event\Event;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Connection;

final class DbalTransactionMiddlewareHandler implements MiddlewareHandler
{
    public function __construct(private readonly Connection $db)
    {}

    /**
     * @throws Throwable
     * @throws Exception
     */
    #[Override]
    public function handle(Event $event, callable $next): void
    {
        $this->db->beginTransaction();

        try {
            $next($event);

            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack();

            throw $e;
        }
    }
}
