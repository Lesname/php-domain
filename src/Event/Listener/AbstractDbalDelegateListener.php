<?php

declare(strict_types=1);

namespace LesDomain\Event\Listener;

use Override;
use Throwable;
use LesDomain\Event\Event;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Connection;

/**
 * @psalm-mutable
 */
abstract class AbstractDbalDelegateListener extends AbstractDelegateListener
{
    /**
     * @psalm-pure
     */
    public function __construct(protected readonly Connection $db)
    {}

    /**
     * @throws Throwable
     * @throws Exception
     *
     * @psalm-impure
     */
    #[Override]
    public function handle(Event $event): void
    {
        $this->db->beginTransaction();

        try {
            parent::handle($event);

            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack();

            throw $e;
        }
    }
}
