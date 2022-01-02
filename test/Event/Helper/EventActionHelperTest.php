<?php
declare(strict_types=1);

namespace LessDomainTest\Event\Helper;

use LessDomain\Event\Helper\EventActionHelper;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDomain\Event\Helper\EventActionHelper
 */
final class EventActionHelperTest extends TestCase
{
    public function testGetAction(): void
    {
        $e = $this->getMockForTrait(
            EventActionHelper::class,
            [],
            'AddedEvent',
        );

        $action = $e->getAction();

        self::assertSame('added', (string)$action);
    }
}
