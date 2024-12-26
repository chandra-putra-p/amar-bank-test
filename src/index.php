<?php

use Handlers\CustomErrorHandler;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Create container
$container = require __DIR__ . '/../config/dependencies.php';

// Create app with container
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$routes = require __DIR__ . '/routes/api.php';
$routes($app);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$customErrorHandler = new CustomErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();
