<?php

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\EventInterface;

abstract class AbstractEvent implements EventInterface
{
    public function __construct(
        protected string $name,
        protected array $data,
        protected ?int $timestamp = null
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