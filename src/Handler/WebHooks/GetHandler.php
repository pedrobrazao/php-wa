<?php

declare(strict_types=1);

namespace App\Handler\WebHooks;

use App\Validator\WebHooks\GetRequestValidator;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetHandler implements RequestHandlerInterface
{
    public const string NAME = 'webhooks_get';
    private const string HUB_CHALLENGE = 'hub.challenge';

    public function __construct(private GetRequestValidator $validator) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->validator->validate($request)->isValid()) {
            $query = Query::parse($request->getUri()->getQuery());
            return new Response(200, [], $query[self::HUB_CHALLENGE]);
        }

        return new Response(400, [], $this->validator->getMessage());
    }
}
