<?php
declare(strict_types=1);

namespace LessDomain\Identifier;

use LessValueObject\String\Format\Resource\Identifier;

interface IdentifierService
{
    public function generate(): Identifier;
}
