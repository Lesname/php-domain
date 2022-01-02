<?php
declare(strict_types=1);

namespace LessDomain\Event\Property;

use LessValueObject\Composite\AbstractCompositeValueObject;
use LessValueObject\Composite\Reference;
use LessValueObject\String\Format\Ip;
use LessValueObject\String\UserAgent;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @psalm-immutable
 */
final class Headers extends AbstractCompositeValueObject
{
    public function __construct(
        public ?UserAgent $userAgent = null,
        public ?Reference $identity = null,
        public ?Ip $ip = null,
    ) {}

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall using getters
     */
    public static function fromRequest(ServerRequestInterface $request): self
    {
        return new self(
            UserAgent::fromRequest($request),
            Reference::fromRequest($request),
            Ip::fromRequest($request),
        );
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
}
