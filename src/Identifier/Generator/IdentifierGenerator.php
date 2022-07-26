<?php
declare(strict_types=1);

namespace LessDomain\Identifier\Generator;

use LessValueObject\String\Format\Resource\Identifier;

interface IdentifierGenerator
{
    public function generate(): Identifier;
}
