<?php
declare(strict_types=1);

namespace LessDomain\Id;

use LessValueObject\String\Exception\TooLong;
use LessValueObject\String\Exception\TooShort;
use LessValueObject\String\Format\Exception\NotFormat;
use LessValueObject\String\Format\Resource\Id;
use Ramsey\Uuid\Uuid;

final class RamseyIdService implements IdService
{
    /**
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    public function generate(): Id
    {
        return new Id((string)Uuid::uuid6());
    }
}
