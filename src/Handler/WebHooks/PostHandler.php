<?php

declare(strict_types=1);

namespace App\Handler\WebHooks;

use App\Validator\WebHooks\GetRequestValidator;
use App\Validator\WebHooks\PostRequestValidator;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class PostHandler implements RequestHandlerInterface
{
    public const string NAME = 'webhooks_post';

    public function __construct(private PostRequestValidator $validator) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->validator->validate($request)->isValid()) {
            return new Response(200);
        }

        return new Response(400);
    }
}
