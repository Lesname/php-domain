<?php
declare(strict_types=1);

namespace LessDomain\Identifier\Generator;

use LessValueObject\String\Exception\TooLong;
use LessValueObject\String\Exception\TooShort;
use LessValueObject\String\Format\Exception\NotFormat;
use LessValueObject\String\Format\Resource\Identifier;
use Ramsey\Uuid\Uuid;

final class Uuid6IdentifierGenerator implements IdentifierGenerator
{
    /**
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    public function generate(): Identifier
    {
        return new Identifier((string)Uuid::uuid6());
    }
}
