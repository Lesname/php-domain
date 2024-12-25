<?php
declare(strict_types=1);

namespace LessDomainTest\Event\Property;

use LessDomain\Event\Property\Headers;
use LessValueObject\Composite\ForeignReference;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @covers \LessDomain\Event\Property\Headers
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
        $headers = Headers::forWorker();

        self::assertSame('worker', (string)$headers->userAgent);
        self::assertNull($headers->identity);
        self::assertSame('::1', (string)$headers->ip);
    }

    public function testForCron(): void
    {
        $headers = Headers::forCron();

        self::assertSame('cron', (string)$headers->userAgent);
        self::assertNull($headers->identity);
        self::assertSame('::1', (string)$headers->ip);
    }

    public function testForCli(): void
    {
        $headers = Headers::forCli();

        self::assertSame('cli', (string)$headers->userAgent);
        self::assertNull($headers->identity);
        self::assertSame('::1', (string)$headers->ip);
    }
}
