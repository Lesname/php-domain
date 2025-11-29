<?php

declare(strict_types=1);

namespace LesDomain\Event\Property;

use Override;
use LesValueObject\String\Exception\TooLong;
use LesValueObject\String\Exception\TooShort;
use LesValueObject\String\Format\Exception\NotFormat;
use LesValueObject\String\Format\AbstractRegexStringFormatValueObject;

/**
 * @psalm-immutable
 */
final class Action extends AbstractRegexStringFormatValueObject
{
    /**
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    public static function fromClassname(string $classname): self
    {
        $classParts = explode('\\', $classname);
        $classname = array_pop($classParts);

        if (str_ends_with($classname, 'Event')) {
            $classname = substr($classname, 0, -5);
        }

        return new self(lcfirst($classname));
    }

    /**
     * @psalm-pure
     */
    #[Override]
    public static function getRegularExpression(): string
    {
        return '/^[a-z][a-zA-Z]*$/';
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
        return 25;
    }
}
