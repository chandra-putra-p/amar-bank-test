<?php

use Controllers\LoanController;
use Handlers\CustomErrorHandler;
use Slim\Factory\AppFactory;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Utils\LoggerUtil;

require __DIR__ . '/../vendor/autoload.php';

// Create container
$container = require __DIR__ . '/../config/dependencies.php';

// Create app with container
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();


$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $logger = new LoggerUtil('helloController');

    $name = $args['name'];
    $logger->info("Hello", ["name" => $name]);

    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->post('/loans', [LoanController::class, 'create']);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$myErrorHandler = new CustomErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
$errorMiddleware->setDefaultErrorHandler($myErrorHandler);

// Get the default error handler and register my custom error renderer.
// $errorHandler = $errorMiddleware->getDefaultErrorHandler();
// $errorHandler->registerErrorRenderer('text/html', MyCustomErrorRenderer::class);

$app->run();