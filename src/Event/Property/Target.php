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
final class Target extends AbstractRegexStringFormatValueObject
{
    /**
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    public static function fromClassname(string $classname): self
    {
        $classParts = explode('\\', $classname);
        $subClassParts = array_slice($classParts, 1, -2);
        $targetParts = array_map(lcfirst(...), $subClassParts);

        return new self(join('.', $targetParts));
    }

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
