<?php
declare(strict_types=1);

namespace LesDomainTest\Event\Property;

use LesDomain\Event\Property\Headers;
use LesValueObject\Composite\ForeignReference;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @covers \LesDomain\Event\Property\Headers
 */
final class HeadersTest extends TestCase
{
    public function testFromRequest(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->expects(self::exactly(2))
            ->method('getHeaderLine')
            ->willReturnMap(
                [
                    ['user-agent', 'fiz'],
                    ['origin', ''],
                ],
            );

        $identity = ForeignReference::fromString('fiz/8400dc71-5f2f-4db1-8ec7-f51e8142593c');
        $request
            ->expects(self::once())
            ->method('getAttribute')
            ->with('identity')
            ->willReturn($identity);

        $request
            ->expects(self::once())
            ->method('getServerParams')
            ->willReturn(['REMOTE_ADDR' => '1.2.3.4']);

        $headers = Headers::fromRequest($request);

        self::assertSame('fiz', (string)$headers->userAgent);
        self::assertSame($identity, $headers->identity);
        self::assertSame('1.2.3.4', (string)$headers->ip);
    }

    public function testForWorker(): void
    {
        $headers = Headers::forWorker('workie');

        self::assertSame('worker:workie', (string)$headers->userAgent);
        self::assertNull($headers->identity);
        self::assertSame('::1', (string)$headers->ip);
    }

    public function testForCron(): void
    {
        $headers = Headers::forCron('job');

        self::assertSame('cron:job', (string)$headers->userAgent);
        self::assertNull($headers->identity);
        self::assertSame('::1', (string)$headers->ip);
    }

    public function testForCli(): void
    {
        $headers = Headers::forCli('exe');

        self::assertSame('cli:exe', (string)$headers->userAgent);
        self::assertNull($headers->identity);
        self::assertSame('::1', (string)$headers->ip);
    }
}
