<?php

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{EventInterface, EventMapperInterface};

abstract class AbstractEventMapper implements EventMapperInterface
{
    /**
     * @var array<string, string>
     */
    protected array $eventNameMap = [];

    /**
     * @var array<string, string>
     */
    protected array $dataKeyMap = [];

    public function map(EventInterface $event): array
    {
        return [
            'name' => $this->getEventName($event),
            'data' => $this->mapEventData($event->getName(), $event->getData()),
            'timestamp' => $event->getTimestamp()
        ];
    }

    public function getEventName(EventInterface $event): string
    {
        return $this->eventNameMap[$event->getName()] ?? $event->getName();
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function mapEventData(string $eventName, array $data): array
    {
        $mappedData = [];
        
        foreach ($data as $key => $value) {
            $mappedKey = $this->dataKeyMap[$key] ?? $key;
            $mappedData[$mappedKey] = $value;
        }

        return $mappedData;
    }

    /**
     * @param array<string, string> $map
     */
    protected function setEventNameMap(array $map): void
    {
        $this->eventNameMap = $map;
    }

    /**
     * @param array<string, string> $map
     */
    protected function setDataKeyMap(array $map): void
    {
        $this->dataKeyMap = $map;
    }
} 