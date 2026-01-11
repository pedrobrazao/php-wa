<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\HomeHandler;
use App\Handler\WebHooks\GetHandler;
use App\Handler\WebHooks\PostHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

final readonly class ApplicationFactory
{
    public function __construct(private ContainerInterface $container) {}

    /** @phpstan-ignore missingType.generics */
    public function create(): App
    {
        AppFactory::setContainer($this->container);

        $app = AppFactory::create();

        $app->add(TwigMiddleware::create($app, $app->getContainer()->get(Twig::class)));
        $app->addRoutingMiddleware();

        $settings = $this->container->get('settings') ?? [];
        $app->addErrorMiddleware($settings['displayErrorDetails'] ?? false, $settings['logErrors'] ?? true, $settings['logErrorDetails'] ?? true, $this->container->get(LoggerInterface::class));

        $app->get('/', HomeHandler::class)->setName(HomeHandler::NAME);
        $app->get('/webhooks', GetHandler::class)->setName(GetHandler::NAME);
        $app->post('/webhooks', PostHandler::class)->setName(PostHandler::NAME);

        return $app;
    }
}
