<?php

declare(strict_types=1);

namespace App\Validator\WebHooks;

use App\Validator\AbstractRequestValidator;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PostRequestValidator extends AbstractRequestValidator
{
    private const string HEADER_X_HUB_SIGNATURE_256 = 'X-Hub-Signature-256';

    public function __construct(private readonly string $secretKey) {}

    public function validate(ServerRequestInterface $request): static
    {
        if ('POST' !== $request->getMethod()) {
            return $this->setInvalid('Invalid HTTP method request.', 400);
        }

        $json = $request->getBody()->getContents();
        $hash = $request->getHeader(self::HEADER_X_HUB_SIGNATURE_256)[0] ?? '';

        if (!str_starts_with($hash, 'sha256=') || substr($hash, 7) !== hash_hmac('sha256', $json, $this->secretKey)) {
            return $this->setInvalid(sprintf('Missing or ivalid parameter "%s" in request headers.', self::HEADER_X_HUB_SIGNATURE_256));
        }
        return $this->setValid();
    }
}
