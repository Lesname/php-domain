<?php
declare(strict_types=1);

namespace LessDomainTest\Event\Property;

use LessDomain\Event\Property\Target;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Event\Property\Target
 */
final class TargetTest extends TestCase
{
    public function testConstruct(): void
    {
        $target = new Target('fiz.bar');

        self::assertSame('fiz.bar', (string)$target);
    }
}
