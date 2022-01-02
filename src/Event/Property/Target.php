<?php
declare(strict_types=1);

namespace LessDomain\Event\Property;

use LessValueObject\String\Format\AbstractRegexpFormattedStringValueObject;

/**
 * @psalm-immutable
 */
final class Target extends AbstractRegexpFormattedStringValueObject
{
    /**
     * @psalm-pure
     */
    public static function getRegexPattern(): string
    {
        return '^[a-z][a-zA-Z]*(\.[a-z][a-zA-Z]*)*$';
    }

    /**
     * @psalm-pure
     */
    public static function getMinLength(): int
    {
        return 1;
    }

    /**
     * @psalm-pure
     */
    public static function getMaxLength(): int
    {
        return 40;
    }
}
