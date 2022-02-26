<?php
declare(strict_types=1);

namespace LessDomain\Event\Helper;

use LessDomain\Event\Property\Action;

/**
 * @psalm-immutable
 */
trait EventActionHelper
{
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
