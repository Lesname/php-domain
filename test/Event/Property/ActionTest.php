<?php
declare(strict_types=1);

namespace LessDomainTest\Event\Property;

use LessDomain\Event\Property\Action;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Event\Property\Action
 */
final class ActionTest extends TestCase
{
    public function testConstruct(): void
    {
        $action = new Action('fiz');

        self::assertSame('fiz', (string)$action);
    }
}
