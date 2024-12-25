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
        $statusCode = 500; // or anything else
        // $errorData  = NBSlimErrorHandler::getExceptionData($exception);

        // feel free to use your own logger here
        // NBLogger::error($errorData["message"], [
        //   "message" => $errorData["message"],
        //   "file"    => $errorData["file"],
        //   "line"    => $errorData["line"],
        //   "trace"   => $errorData["trace"],
        // ]);
        $response = $this->responseFactory->createResponse($statusCode);

        if ($exception instanceof NestedValidationException) {
            $errors = $exception->getMessages();
            // $response->getBody()->write(json_encode([
            //     'error' => 'Validation failed',
            //     'details' => $errors,
            // ], JSON_PRETTY_PRINT));
            // return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

            return ResponseUtil::json($response, 'Validation failed', null, 400, $errors);
        }

        // $response     = $psr17Factory->createResponse($statusCode);
        $response->getBody()->write(json_encode([
            "success" => false,
            "error"   => $exception->getMessage(),
        ]));
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }

    // Helper Function to extract data from an exception
    //   public static function getExceptionData(Throwable $exception)
    //   {
    //     $stripPath = getPublicHtmlFolder(); // see below

    //     $message = $exception->getMessage();
    //     $file    = implode("", explode($stripPath, $exception->getFile())); // remove $stripPath
    //     $line    = $exception->getLine();
    //     $trace   = $exception->getTraceAsString();
    //     $trace   = explode("\n", substr(implode("", explode($stripPath, $trace)), 1));
    //     return [
    //       "message" => $message,
    //       "file"    => $file,
    //       "line"    => $line,
    //       "trace"   => $trace,
    //     ];
    //   }

}
