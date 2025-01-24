<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Exceptions;

/**
 * Exception thrown when validation fails.
 * Contains validation errors as key-value pairs.
 */
class ValidationException extends \Exception
{
    /**
     * @param array<string, string> $errors Validation errors
     */
    public function __construct(
        string $message,
        private readonly array $errors = [],
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /** @return array<string, string> */
    public function getErrors(): array
    {
        return $this->errors;
    }
} 