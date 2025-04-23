<?php
declare(strict_types=1);

namespace LesDomain\Identifier\Generator;

use LesValueObject\String\Format\Resource\Identifier;

interface IdentifierGenerator
{
    public function generate(): Identifier;
}
