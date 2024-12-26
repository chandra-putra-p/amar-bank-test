<?php

namespace Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \Slim\Interfaces\ErrorHandlerInterface;
use Slim\Interfaces\CallableResolverInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Throwable;

use Utils\ResponseUtil;

class CustomErrorHandler implements ErrorHandlerInterface
{
    protected CallableResolverInterface $callableResolver;

    protected ResponseFactoryInterface $responseFactory;

    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
    ) {
        $this->callableResolver = $callableResolver;
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails): ResponseInterface
    {
        $statusCode = 500;
        $response = $this->responseFactory->createResponse($statusCode);

        if ($exception instanceof NestedValidationException) {
            $errors = $exception->getMessages();
            return ResponseUtil::json($response, 'Validation failed', null, 400, $errors);
        }

        $response->getBody()->write(json_encode([
            "success" => false,
            "error"   => $exception->getMessage(),
        ]));
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }
}
