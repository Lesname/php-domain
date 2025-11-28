<?php

declare(strict_types=1);

namespace LesDomain\Event\Property;

use Override;
use LesValueObject\String\Format\AbstractRegexStringFormatValueObject;

/**
 * @psalm-immutable
 */
final class Target extends AbstractRegexStringFormatValueObject
{
    /**
     * @psalm-pure
     */
    #[Override]
    public static function getRegularExpression(): string
    {
        return '/^[a-z][a-zA-Z]*(\.[a-z][a-zA-Z]*)*$/';
    }

    /**
     * @psalm-pure
     */
    #[Override]
    public static function getMinimumLength(): int
    {
        return 1;
    }

    /**
     * @psalm-pure
     */
    #[Override]
    public static function getMaximumLength(): int
    {
        return 40;
    }
}
