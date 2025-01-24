<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\EventInterface;

/**
 * Base class for all events in the system.
 */
readonly abstract class AbstractEvent implements EventInterface
{
    public function __construct(
        private string $name,
        private array $data,
        private ?int $timestamp = null
    ) {
        $this->timestamp = $timestamp ?? time();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
} 