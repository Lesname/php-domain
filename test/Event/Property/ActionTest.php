<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Property;

use LesDomain\Event\Property\Action;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LesDomain\Event\Property\Action
 */
final class ActionTest extends TestCase
{
    public function testConstruct(): void
    {
        $action = new Action('fiz');

        self::assertSame('fiz', (string)$action);
    }
}
