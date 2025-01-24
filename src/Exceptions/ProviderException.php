<?php

namespace Trovee\EventRelay\Exceptions;

class ProviderException extends \Exception
{
    public function __construct(
        string $message,
        private string $providerName,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getProviderName(): string
    {
        return $this->providerName;
    }
} 