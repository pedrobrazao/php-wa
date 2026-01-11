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
use Psr\Log\LoggerInterface;

final readonly class PostHandler implements RequestHandlerInterface
{
    public const string NAME = 'webhooks_post';

    public function __construct(
        private PostRequestValidator $validator,
        private LoggerInterface $logger,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $json = $request->getBody()->getContents();

        if ($this->validator->validate($request)->isValid()) {
            $this->logger->info('Webhook created.', [
                'uri' => $request->getUri(),
                'payload' => $json,
            ]);
            return new Response(200);
        }

        $this->logger->warning('Bad POST request.', [
            'uri' => (string) $request->getUri(),
            'headers' => $request->getHeaders(),
            'payload' => $json,
            'error' => $this->validator->getMessage(),
        ]);

        return new Response(400);
    }
}
