<?php

namespace Trovee\EventRelay\Contracts;

interface EventMapperInterface
{
    /**
     * Map event to provider-specific format
     *
     * @return array<string, mixed>
     */
    public function map(EventInterface $event): array;
    
    /**
     * Get provider-specific event name
     */
    public function getEventName(EventInterface $event): string;
    
    /**
     * Map event data to provider-specific format
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function mapEventData(string $eventName, array $data): array;
}