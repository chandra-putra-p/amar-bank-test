<?php

use Controllers\LoanController;
use Slim\Routing\RouteCollectorProxy;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

return function (RouteCollectorProxy $router) {
    $router->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Don't worry, I'm alive :)");

        return $response;
    });

    // Loan routes
    $router->group('/loans', function (RouteCollectorProxy $group) {
        $group->post('', [LoanController::class, 'create']);
    });
};
