<?php

use Dotenv\Dotenv;
use Monolog\Level;
use Monolog\Logger;

// Load values from .env into environmental variables
Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();
$isDev = 'dev' === ($_ENV['APP_ENV'] ?? 'prod');

return [
    'displayErrorDetails' => (bool) ($_ENV['APP_DISPLAY_ERROR_DETAILS'] ?? $isDev), // Should be set to false in production
    'logErrors' => (bool) ($_ENV['APP_LOG_ERRORS'] ?? true),
    'logErrorDetails' => (bool) ($_ENV['APP_LOG_ERROR_DETAILS'] ?? true),
    'logger' => [
        'name' => $_ENV['LOGGER_NAME'] ?? 'app',
        'path' => $_ENV['LOGGER_PATH'] ?? __DIR__ . '/../var/logs' . ($isDev ? sprintf('/dev%s.log', date('Ymd')) : '/app.log'),
        'level' => $_ENV['LOGGER_LEVEL'] ?? ($isDev ? Level::Debug : Level::Info),
    ],
    'twig' => [
        'path' => $_ENV['TWIG_TEMPLATES_PATH'] ?? __DIR__ . '/../templates',
        'options' => [
            'cache' => $_ENV['TWIG_CACHE'] ?? ($isDev ? false : __DIR__ . '/../var/cache/'),
        ],
    ],
    'wa' => [
        'fbAppId' => $_ENV['FB_APP_ID'] ?? '',
        'fbAppSecret' => $_ENV['FB_APP_SECRET'] ?? '',
        'verifyToken' => $_ENV['WA_VERIFY_TOKEN'] ?? '',
    ],
];
