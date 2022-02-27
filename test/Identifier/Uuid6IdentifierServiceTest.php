<?php
declare(strict_types=1);

namespace LessDomainTest\Identifier;

use LessDomain\Identifier\Uuid6IdentifierService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Identifier\Uuid6IdentifierService
 */
final class Uuid6IdentifierServiceTest extends TestCase
{
    public function testGenerate(): void
    {
        $service = new Uuid6IdentifierService();

        $first = $service->generate();
        $second = $service->generate();

        self::assertNotSame($first, $second);
    }
}
