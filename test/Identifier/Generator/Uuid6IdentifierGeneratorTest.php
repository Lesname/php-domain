<?php
declare(strict_types=1);

namespace LesDomainTest\Identifier\Generator;

use LesDomain\Identifier\Generator\Uuid6IdentifierGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Identifier\Generator\Uuid6IdentifierGenerator
 */
final class Uuid6IdentifierGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $service = new Uuid6IdentifierGenerator();

        $first = $service->generate();
        $second = $service->generate();

        self::assertNotSame($first, $second);
    }
}
