<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Exceptions;

/**
 * Exception thrown when a client request fails.
 * Contains protocol, method, and endpoint information.
 */
class ClientException extends \Exception
{
    public function __construct(
        string $message,
        private readonly ?string $protocol = null,
        private readonly ?string $method = null,
        private readonly ?string $endpoint = null,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getProtocol(): ?string
    {
        return $this->protocol;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }
} 