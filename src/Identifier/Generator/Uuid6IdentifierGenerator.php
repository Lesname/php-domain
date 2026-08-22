<?php

declare(strict_types=1);

namespace LesDomain\Identifier\Generator;

use Override;
use Random\RandomException;
use LesValueObject\String\Exception\TooLong;
use LesValueObject\String\Exception\TooShort;
use LesValueObject\String\Format\Exception\NotFormat;
use LesValueObject\String\Format\Resource\Identifier;

final class Uuid6IdentifierGenerator implements IdentifierGenerator
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
        // UUID timestamp:
        // 100-ns intervals since 1582-10-15 00:00:00 UTC
        $unixTimestamp = microtime(true);

        $gregorianOffset = 12219292800;

        $seconds = (int) floor($unixTimestamp);
        $fraction = $unixTimestamp - $seconds;

        $timestamp = ($seconds + $gregorianOffset) * 10_000_000
            + (int) floor($fraction * 10_000_000);

        // 60-bit timestamp:
        // timestamp_high (32 bits)
        // timestamp_mid  (16 bits)
        // timestamp_low  (12 bits)
        $timeHigh = ($timestamp >> 28) & 0xFFFFFFFF;
        $timeMid  = ($timestamp >> 12) & 0xFFFF;
        $timeLow  = $timestamp & 0xFFF;

        $uuid = pack('Nn', $timeHigh, $timeMid)
            . pack('n', $timeLow)
            . random_bytes(8);

        // Version 6
        $uuid[6] = chr((ord($uuid[6]) & 0x0F) | 0x60);

        // RFC 9562 variant: 10xxxxxx
        $uuid[8] = chr((ord($uuid[8]) & 0x3F) | 0x80);

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
