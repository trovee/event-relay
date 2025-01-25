<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Contracts;

interface EventRelayInterface
{
    public function dispatch(string $event, array $payload = []): void;
} 