<?php

declare(strict_types=1);

namespace LesDomain\Event\Property\Header;

use LesValueObject\Enum\EnumValueObject;
use LesValueObject\Enum\Helper\EnumValueHelper;

/**
 * @psalm-immutable
 */
enum SpamDetection: string implements EnumValueObject
{
    use EnumValueHelper;

    case Detected = 'detected';
    case Honeypot = 'honeypot';
    case Content = 'content';
    case IP = 'ip';
}
