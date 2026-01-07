<?php

declare(strict_types=1);

namespace App\Validator\WebHooks;

use App\Validator\AbstractRequestValidator;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class GetRequestValidator extends AbstractRequestValidator
{
    private const string HUB_MODE = 'hub.mode';
    private const string HUB_CHALLENGE = 'hub.challenge';
    private const string HUB_VERIFY_TOKEN = 'hub.verify_token';

    public function __construct(private readonly string $verifyToken) {}

    public function validate(ServerRequestInterface $request): static
    {
        if ('GET' !== $request->getMethod()) {
            return $this->setInvalid('Invalid HTTP method request.', 400);
        }

        $query = Query::parse($request->getUri()->getQuery());

        if (!isset($query[self::HUB_MODE]) || 'subscribe' !== $query[self::HUB_MODE]) {
            return $this->setInvalid(sprintf('Missing or invalid parameter "%s" in query string.', self::HUB_MODE), 400);
        }

        if (!isset($query[self::HUB_CHALLENGE])) {
            return $this->setInvalid(sprintf('Missing or invalid parameter "%s" in query string.', self::HUB_CHALLENGE), 400);
        }

        if (!isset($query[self::HUB_VERIFY_TOKEN]) || $this->verifyToken !== $query[self::HUB_VERIFY_TOKEN]) {
            return $this->setInvalid(sprintf('Missing or invalid parameter "%s" in query string.', self::HUB_VERIFY_TOKEN), 400);
        }

        return $this->setValid();
    }
}
