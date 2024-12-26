<?php

namespace Utils;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerUtil
{
    private $logger;

    public function __construct(
        string $name
    ) {
        $this->logger = new Logger($name);
        $this->logger->pushHandler(new StreamHandler("php://stdout", Level::Debug));
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function debug(string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }
}
