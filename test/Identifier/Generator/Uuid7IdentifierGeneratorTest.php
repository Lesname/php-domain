<?php
declare(strict_types=1);

namespace LessDomainTest\Identifier\Generator;

use LessDomain\Identifier\Generator\Uuid7IdentifierGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Identifier\Generator\Uuid7IdentifierGenerator
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
