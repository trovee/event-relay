<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Exceptions;

use Trovee\EventRelay\Contracts\EventInterface;

/**
 * Exception thrown when event dispatching fails.
 * Contains the event that caused the error.
 */
class DispatcherException extends \Exception
{
    public function __construct(
        string $message,
        private readonly EventInterface $event,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function getEvent(): EventInterface
    {
        return $this->event;
    }
} 