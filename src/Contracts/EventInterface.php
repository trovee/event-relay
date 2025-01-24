<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Contracts;

interface EventInterface
{
    /**
     * Get the name of the event
     */
    public function getName(): string;

    /**
     * Get the event data
     *
     * @return array<string, mixed>
     */
    public function getData(): array;

    /**
     * Get the timestamp when the event occurred
     */
    public function getTimestamp(): int;
} 