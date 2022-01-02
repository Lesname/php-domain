<?php
declare(strict_types=1);

namespace LessDomainTest\Id;

use LessDomain\Id\RamseyIdService;
use LessValueObject\String\Format\Reference\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Id\RamseyIdService
 */
final class RamseyIdServiceTest extends TestCase
{
    public function testGenerate(): void
    {
        $service = new RamseyIdService();
        $id = $service->generate();

        self::assertInstanceOf(Id::class, $id);
    }
}
