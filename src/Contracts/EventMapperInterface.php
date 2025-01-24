<?php

namespace Trovee\EventRelay\Contracts;

interface EventMapperInterface
{
    public function mapEventName(string $eventName): string;
    public function mapEventData(string $eventName, array $data): array;
}