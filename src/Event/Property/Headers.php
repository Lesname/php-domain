<?php
declare(strict_types=1);

namespace LessDomain\Event\Property;

use LessValueObject\String\Format\Uri\Https;
use LessValueObject\Composite\AbstractCompositeValueObject;
use LessValueObject\Composite\ForeignReference;
use LessValueObject\String\Exception\TooLong;
use LessValueObject\String\Exception\TooShort;
use LessValueObject\String\Format\Exception\NotFormat;
use LessValueObject\String\Format\Ip;
use LessValueObject\String\UserAgent;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @psalm-immutable
 */
final class Headers extends AbstractCompositeValueObject
{
    public function __construct(
        public readonly ?UserAgent $userAgent = null,
        public readonly ?ForeignReference $identity = null,
        public readonly ?Ip $ip = null,
        public readonly ?Https $origin = null,
    ) {}

    /**
     * @psalm-pure
     *
     * @throws NotFormat
     * @throws TooLong
     * @throws TooShort
     */
    public static function fromRequest(ServerRequestInterface $request): self
    {
        return new self(
            self::fromRequestUserAgent($request),
            self::fromRequestIdentity($request),
            self::fromRequestIP($request),
            self::fromRequestOrigin($request),
        );
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall getter is pure
     *
     * @throws TooLong
     * @throws TooShort
     */
    private static function fromRequestUserAgent(ServerRequestInterface $request): ?UserAgent
    {
        $userAgent = trim($request->getHeaderLine('user-agent')) ?: null;

        return $userAgent && mb_strlen($userAgent) >= UserAgent::getMinimumLength()
            ? new UserAgent(mb_substr($userAgent, 0, UserAgent::getMaximumLength()))
            : null;
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall getter is pure
     */
    private static function fromRequestIdentity(ServerRequestInterface $request): ?ForeignReference
    {
        $identity = $request->getAttribute('identity');
        assert($identity instanceof ForeignReference || is_null($identity));

        return $identity;
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall getter is pure
     *
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    private static function fromRequestIP(ServerRequestInterface $request): ?Ip
    {
        $params = $request->getServerParams();

        return isset($params['REMOTE_ADDR']) && is_string($params['REMOTE_ADDR'])
            ? new Ip($params['REMOTE_ADDR'])
            : null;
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall getter is pure
     *
     * @throws TooLong
     * @throws TooShort
     * @throws NotFormat
     */
    private static function fromRequestOrigin(ServerRequestInterface $request): ?Https
    {
        $origin = trim($request->getHeaderLine('origin')) ?: null;

        return $origin && Https::isFormat($origin)
            ? new Https($origin)
            : null;
    }

    /**
     * @psalm-pure
     */
    public static function forWorker(): self
    {
        return new self(
            userAgent: new UserAgent('worker'),
            ip: Ip::local(),
        );
    }

    /**
     * @psalm-pure
     */
    public static function forCron(): self
    {
        return new self(
            userAgent: new UserAgent('cron'),
            ip: Ip::local(),
        );
    }

    /**
     * @psalm-pure
     */
    public static function forCli(): self
    {
        return new self(
            userAgent: new UserAgent('cli'),
            ip: Ip::local(),
        );
    }

    /**
     * @psalm-pure
     */
    public static function forEffect(): self
    {
        return new self(
            userAgent: new UserAgent('effect'),
            ip: Ip::local(),
        );
    }
}
