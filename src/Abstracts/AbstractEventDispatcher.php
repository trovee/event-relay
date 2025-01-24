<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{EventDispatcherInterface, EventInterface, ProviderInterface};
use Trovee\EventRelay\Exceptions\DispatcherException;

/**
 * Base class for event dispatchers that handle sending events to multiple providers.
 * Manages provider registration and event dispatching.
 */
abstract class AbstractEventDispatcher implements EventDispatcherInterface
{
    /** @var array<string, ProviderInterface> Registered providers indexed by name */
    private readonly array $providers;

    public function __construct()
    {
        $this->providers = [];
    }

    /**
     * Add a provider to the dispatcher.
     * 
     * @throws \InvalidArgumentException if provider with same name already exists
     */
    public function addProvider(ProviderInterface $provider): void
    {
        $name = $provider->getName();
        if (isset($this->providers[$name])) {
            throw new \InvalidArgumentException("Provider '{$name}' already exists");
        }
        
        $this->providers[$name] = $provider;
    }

    /**
     * Remove a provider from the dispatcher.
     * 
     * @throws \InvalidArgumentException if provider not found
     */
    public function removeProvider(string $providerName): void
    {
        if (!isset($this->providers[$providerName])) {
            throw new \InvalidArgumentException("Provider '{$providerName}' not found");
        }
        
        unset($this->providers[$providerName]);
    }

    /**
     * Check if a provider exists in the dispatcher.
     */
    public function hasProvider(string $providerName): bool
    {
        return isset($this->providers[$providerName]);
    }

    /**
     * Get all registered providers.
     * 
     * @return array<string, ProviderInterface>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    public function dispatch(EventInterface $event): array
    {
        if (empty($this->providers)) {
            throw new DispatcherException('No providers registered', $event);
        }

        $results = [];
        foreach ($this->providers as $name => $provider) {
            try {
                $results[$name] = $provider->send($event);
            } catch (\Throwable $e) {
                throw new DispatcherException(
                    "Failed to dispatch event to provider '{$name}': {$e->getMessage()}",
                    $event,
                    $e
                );
            }
        }
        
        return $results;
    }
} 