<?php
declare(strict_types=1);

namespace LesDomain\Event\Helper;

use LesDomain\Event\Property\Action;

/**
 * @psalm-immutable
 *
 * @phpstan-ignore trait.unused
 */
trait EventActionHelper
{
    // phpcs:ignore
    public Action $action {
        get {
            // phpcs:ignore
            return $this->getAction();
        }
    }

    /**
     * @psalm-pure
     */
    public function getAction(): Action
    {
        $classNameParts = explode('\\', static::class);
        $className = array_pop($classNameParts);

        if (str_ends_with($className, 'Event')) {
            $className = substr($className, 0, -5);
        }

        return new Action(lcfirst($className));
    }
}
