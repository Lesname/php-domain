<?php
declare(strict_types=1);

namespace LesDomainTest\Identifier\Generator;

use LesDomain\Identifier\Generator\Uuid7IdentifierGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Identifier\Generator\Uuid7IdentifierGenerator
 */
class Uuid7IdentifierGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $service = new Uuid7IdentifierGenerator();

        $first = $service->generate();
        $second = $service->generate();

        self::assertNotSame($first, $second);
    }
}
