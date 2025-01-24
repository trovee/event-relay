<?php

namespace Trovee\EventRelay\Contracts;

interface ProviderInterface
{
    public function send(string $eventName, array $data): bool;
    public function getName(): string;
}