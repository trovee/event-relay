<?php

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{EventDispatcherInterface, EventInterface, ProviderInterface};
use Trovee\EventRelay\Exceptions\DispatcherException;

abstract class AbstractEventDispatcher implements EventDispatcherInterface
{
    /** @var array<string, ProviderInterface> */
    protected array $providers = [];

    public function addProvider(ProviderInterface $provider): void
    {
        $this->providers[$provider->getName()] = $provider;
    }

    public function removeProvider(string $providerName): void
    {
        unset($this->providers[$providerName]);
    }

    public function getProviders(): array
    {
        return $this->providers;
    }

    public function dispatch(EventInterface $event): array
    {
        $results = [];

        foreach ($this->providers as $name => $provider) {
            try {
                $results[$name] = $provider->supports($event)
                    ? $provider->send($event)
                    : false;
            } catch (\Exception $e) {
                throw new DispatcherException(
                    "Failed to dispatch event to provider: {$name}",
                    $event,
                    $e
                );
            }
        }

        return $results;
    }
} 