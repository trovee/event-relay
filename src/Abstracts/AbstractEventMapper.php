<?php

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{EventInterface, EventMapperInterface};

abstract class AbstractEventMapper implements EventMapperInterface
{
    public function map(EventInterface $event): array
    {
        return [
            'name' => $this->getEventName($event),
            'data' => $this->mapEventData($event->getName(), $event->getData()),
            'timestamp' => $event->getTimestamp()
        ];
    }

    abstract public function mapEventData(string $eventName, array $data): array;
} 