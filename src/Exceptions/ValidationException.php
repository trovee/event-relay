<?php

namespace Trovee\EventRelay\Exceptions;

class ValidationException extends \Exception
{
    /**
     * @param array<string, string> $errors
     */
    public function __construct(
        string $message,
        private array $errors = [],
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
} 