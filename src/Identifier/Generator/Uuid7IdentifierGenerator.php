<?php
declare(strict_types=1);

namespace LessDomain\Identifier\Generator;

use Ramsey\Uuid\Uuid;
use LessValueObject\String\Exception\TooLong;
use LessValueObject\String\Exception\TooShort;
use LessValueObject\String\Format\Exception\NotFormat;
use LessValueObject\String\Format\Resource\Identifier;

final class Uuid7IdentifierGenerator implements IdentifierGenerator
{
    /**
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    public function generate(): Identifier
    {
        return new Identifier((string)Uuid::uuid7());
    }
}
