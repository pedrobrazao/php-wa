<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

final class HomeHandler implements RequestHandlerInterface
{
    public const string NAME = 'home';
    private const string TEMPLATE = 'home.html.twig';

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        return Twig::fromRequest($request)->render(new Response(), self::TEMPLATE, []);
    }
}
