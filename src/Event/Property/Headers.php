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
    /**
     * @psalm-pure
     */
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
        // @phpstan-ignore possiblyImpure.methodCall
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
        // @phpstan-ignore possiblyImpure.methodCall
        $identity = $request->getAttribute('identity');

        if (!$identity instanceof ForeignReference && $identity !== null) {
            throw new RuntimeException();
        }

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
        // @phpstan-ignore possiblyImpure.methodCall
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
        // @phpstan-ignore possiblyImpure.methodCall
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
     *
     * @throws UnknownVersion
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
     *
     * @throws UnknownVersion
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
     *
     * @throws UnknownVersion
     */
    public static function forEffect(): self
    {
        return new self(
            userAgent: new UserAgent('effect'),
            ip: Ip::local(),
        );
    }
}
