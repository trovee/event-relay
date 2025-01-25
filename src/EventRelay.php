<?php

declare(strict_types=1);

namespace Trovee\EventRelay;

use Trovee\EventRelay\Contracts\EventRelayInterface;
use Trovee\EventRelay\Contracts\ClientInterface;

class EventRelay implements EventRelayInterface
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly array $providers = []
    ) {}

    public function dispatch(string $event, array $payload = []): void
    {
        foreach ($this->providers as $provider) {
            // Provider implementation will be added
        }
    }
} 