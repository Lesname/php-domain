<?php

declare(strict_types=1);

namespace LesDomain\Identifier\Generator;

use LesValueObject\String\Format\Resource\Identifier;

/**
 * @psalm-mutable
 */
interface IdentifierGenerator
{
    /**
     * @psalm-impure
     */
    public function generate(): Identifier;
}
