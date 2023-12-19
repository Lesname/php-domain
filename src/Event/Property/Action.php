<?php
declare(strict_types=1);

namespace LessDomain\Event\Property;

use LessValueObject\String\Format\AbstractRegexStringFormatValueObject;

/**
 * @psalm-immutable
 */
final class Action extends AbstractRegexStringFormatValueObject
{
    /**
     * @psalm-pure
     */
    public static function getRegularExpression(): string
    {
        return '/^[a-z][a-zA-Z]*$/';
    }

    /**
     * @psalm-pure
     */
    public static function getMinimumLength(): int
    {
        return 1;
    }

    /**
     * @psalm-pure
     */
    public static function getMaximumLength(): int
    {
        return 25;
    }
}
