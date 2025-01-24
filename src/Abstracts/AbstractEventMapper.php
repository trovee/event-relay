<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{EventInterface, EventMapperInterface};

/**
 * Base class for event mappers that transform events into provider-specific formats.
 * Handles event name and data mapping based on configured maps.
 */
abstract class AbstractEventMapper implements EventMapperInterface
{
    /** @var array<string, string> Map of internal event names to provider-specific names */
    private readonly array $eventNameMap;

    /** @var array<string, string> Map of internal data keys to provider-specific keys */
    private readonly array $dataKeyMap;

    public function __construct()
    {
        $this->eventNameMap = [];
        $this->dataKeyMap = [];
    }

    /**
     * Map an event to provider-specific format.
     * 
     * @return array{name: string, data: array<string, mixed>, timestamp: int}
     */
    public function map(EventInterface $event): array
    {
        return [
            'name' => $this->getEventName($event),
            'data' => $this->mapEventData($event->getName(), $event->getData()),
            'timestamp' => $event->getTimestamp(),
        ];
    }

    /**
     * Get provider-specific event name.
     * Falls back to original name if no mapping exists.
     */
    public function getEventName(EventInterface $event): string
    {
        return $this->eventNameMap[$event->getName()] ?? $event->getName();
    }

    /**
     * Map event data to provider-specific format.
     * 
     * @param array<string, mixed> $data Original event data
     * @return array<string, mixed> Mapped event data
     */
    public function mapEventData(string $eventName, array $data): array
    {
        $mappedData = [];
        
        foreach ($data as $key => $value) {
            $mappedKey = $this->dataKeyMap[$key] ?? $key;
            $mappedData[$mappedKey] = $this->transformValue($value);
        }

        return $mappedData;
    }

    /**
     * @param array<string, string> $map
     */
    protected function setEventNameMap(array $map): void
    {
        /** @var array<string, string> $map */
        $this->eventNameMap = $map;
    }

    /**
     * @param array<string, string> $map
     */
    protected function setDataKeyMap(array $map): void
    {
        /** @var array<string, string> $map */
        $this->dataKeyMap = $map;
    }

    /**
     * @return array<string, string>
     */
    protected function getEventNameMap(): array
    {
        return $this->eventNameMap;
    }

    /**
     * @return array<string, string>
     */
    protected function getDataKeyMap(): array
    {
        return $this->dataKeyMap;
    }

    /**
     * @template T of scalar|array|object|null
     * @param T $value
     * @return T
     */
    protected function transformValue(mixed $value): mixed
    {
        return $value;
    }
} 