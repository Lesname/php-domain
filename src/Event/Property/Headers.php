<?php

declare(strict_types=1);

namespace LesDomain\Event\Property;

use RuntimeException;
use LesValueObject\String\Format\Uri\Https;
use LesValueObject\Composite\AbstractCompositeValueObject;
use LesValueObject\Composite\ForeignReference;
use LesValueObject\String\Exception\TooLong;
use LesValueObject\String\Exception\TooShort;
use LesValueObject\String\Format\Exception\NotFormat;
use LesValueObject\String\Format\Ip;
use LesValueObject\String\UserAgent;
use Psr\Http\Message\ServerRequestInterface;
use LesValueObject\String\Format\Exception\UnknownVersion;

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

    private static function fromRequestIdentity(ServerRequestInterface $request): ?ForeignReference
    {
        $identity = $request->getAttribute('identity');

        if (!$identity instanceof ForeignReference && $identity !== null) {
            throw new RuntimeException();
        }

        return $identity;
    }

    /**
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

    public static function forWorker(string $name): self
    {
        return new self(
            userAgent: new UserAgent("worker:{$name}"),
            ip: Ip::local(),
        );
    }

    /**
     * @throws UnknownVersion
     */
    public static function forCron(string $name): self
    {
        return new self(
            userAgent: new UserAgent("cron:{$name}"),
            ip: Ip::local(),
        );
    }

    /**
     * @throws UnknownVersion
     */
    public static function forCli(string $name): self
    {
        return new self(
            userAgent: new UserAgent("cli:{$name}"),
            ip: Ip::local(),
        );
    }

    /**
     * @throws UnknownVersion
     */
    public static function forEffect(string $name): self
    {
        return new self(
            userAgent: new UserAgent("effect:{$name}"),
            ip: Ip::local(),
        );
    }
}
