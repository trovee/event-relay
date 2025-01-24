<?php

namespace Trovee\EventRelay\Exceptions;

class HttpException extends \Exception
{
    public function __construct(
        string $message,
        private string $method,
        private string $endpoint,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }
}