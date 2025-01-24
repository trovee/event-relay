<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Exceptions;

/**
 * Exception thrown when a provider-specific error occurs.
 * Contains the name of the provider that caused the error.
 */
class ProviderException extends \Exception
{
    public function __construct(
        string $message,
        private readonly string $providerName,
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