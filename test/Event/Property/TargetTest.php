<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Property;

use LesDomain\Event\Property\Target;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\Property\Target
 */
final class TargetTest extends TestCase
{
    public function testConstruct(): void
    {
        $target = new Target('fiz.bar');

        self::assertSame('fiz.bar', (string)$target);
    }
}
