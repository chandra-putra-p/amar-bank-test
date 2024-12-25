<?php
namespace Utils;

use Monolog\Level;
use Monolog\Logger;
// use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;

class LoggerUtil {
    private $logger;
    // private $logDirectory;

    public function __construct(
        string $name,
        // string $logDirectory = __DIR__ . '/../logs',
        // int $retentionDays = 30
    ) {
        // $this->logDirectory = $logDirectory;
        $this->logger = new Logger($name);

        // Create log directory if it doesn't exist
        // if (!is_dir($this->logDirectory)) {
        //     mkdir($this->logDirectory, 0777, true);
        // }

        // Add handlers
        // $this->logger->pushHandler(new RotatingFileHandler(
        //     $this->logDirectory . '/' . $name . '.log',
        //     $retentionDays,
        //     Level::Debug
        // ));

        $this->logger->pushHandler(new StreamHandler("php://stdout", Level::Debug));

        // Add processors for extra information
        // $this->logger->pushProcessor(new IntrospectionProcessor());
        // $this->logger->pushProcessor(new WebProcessor());
    }

    public function getLogger(): Logger {
        return $this->logger;
    }

    public function debug(string $message, array $context = []): void {
        $this->logger->debug($message, $context);
    }

    public function info(string $message, array $context = []): void {
        $this->logger->info($message, $context);
    }

    public function warning(string $message, array $context = []): void {
        $this->logger->warning($message, $context);
    }

    public function error(string $message, array $context = []): void {
        $this->logger->error($message, $context);
    }

    public function logRequest($request): void {
        $this->info('Incoming Request', [
            'method' => $request->getMethod(),
            'uri' => (string)$request->getUri(),
            'headers' => $request->getHeaders(),
            'body' => $request->getParsedBody()
        ]);
    }

    public function logResponse($response): void {
        $this->info('Outgoing Response', [
            'status' => $response->getStatusCode(),
            'headers' => $response->getHeaders()
        ]);
    }
}