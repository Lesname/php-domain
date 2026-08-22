<?php

declare(strict_types=1);

namespace LesDomain\Identifier\Generator;

use Override;
use Random\RandomException;
use LesValueObject\String\Exception\TooLong;
use LesValueObject\String\Exception\TooShort;
use LesValueObject\String\Format\Exception\NotFormat;
use LesValueObject\String\Format\Resource\Identifier;

final class Uuid7IdentifierGenerator implements IdentifierGenerator
{
    /**
     * @throws NotFormat
     * @throws TooLong
     * @throws TooShort
     * @throws RandomException
     */
    #[Override]
    public function generate(): Identifier
    {
        // Unix timestamp in milliseconds (48 bits)
        $timestamp = (int) floor(microtime(true) * 1000);

        // 48-bit timestamp, big-endian
        $uuid = pack(
            'C6',
            ($timestamp >> 40) & 0xff,
            ($timestamp >> 32) & 0xff,
            ($timestamp >> 24) & 0xff,
            ($timestamp >> 16) & 0xff,
            ($timestamp >> 8)  & 0xff,
            $timestamp & 0xff,
        );

        // Remaining 80 bits are initially random
        $uuid .= random_bytes(10);

        // Set version = 7 (0111xxxx)
        $uuid[6] = chr((ord($uuid[6]) & 0x0f) | 0x70);

        // Set variant = RFC 9562 (10xxxxxx)
        $uuid[8] = chr((ord($uuid[8]) & 0x3f) | 0x80);

        // Canonical UUID representation
        $hex = bin2hex($uuid);

        return new Identifier(
            sprintf(
                '%s-%s-%s-%s-%s',
                substr($hex, 0, 8),
                substr($hex, 8, 4),
                substr($hex, 12, 4),
                substr($hex, 16, 4),
                substr($hex, 20, 12),
            ),
        );
    }
}
