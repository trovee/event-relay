<?php

namespace Trovee\EventRelay\Contracts;

interface EventMapperInterface
{
    public function map(EventInterface $event): array;
    
    public function getEventName(EventInterface $event): string;
    
    public function mapEventData(string $eventName, array $data): array;
}