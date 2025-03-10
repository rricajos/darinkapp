<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerService {
    private $logger;

    public function __construct() {
        $this->logger = new Logger('app_logger');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app.log', Logger::DEBUG));
    }

    public function log($level, $message) {
        $this->logger->log($level, $message);
    }
}
