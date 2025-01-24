<?php

namespace Trovee\EventRelay\Exceptions;

use Trovee\EventRelay\Contracts\EventInterface;

class DispatcherException extends \Exception
{
    public function __construct(
        string $message,
        private EventInterface $event,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function getEvent(): EventInterface
    {
        return $this->event;
    }
} 