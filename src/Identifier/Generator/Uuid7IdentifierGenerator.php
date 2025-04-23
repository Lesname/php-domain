<?php
declare(strict_types=1);

namespace LesDomain\Identifier\Generator;

use Override;
use Ramsey\Uuid\Uuid;
use LesValueObject\String\Exception\TooLong;
use LesValueObject\String\Exception\TooShort;
use LesValueObject\String\Format\Exception\NotFormat;
use LesValueObject\String\Format\Resource\Identifier;

final class Uuid7IdentifierGenerator implements IdentifierGenerator
{
    /**
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    #[Override]
    public function generate(): Identifier
    {
        return new Identifier((string)Uuid::uuid7());
    }
}
