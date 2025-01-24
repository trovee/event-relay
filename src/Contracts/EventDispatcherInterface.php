<?php

namespace Trovee\EventRelay\Contracts;

use Trovee\EventRelay\Contracts\EventInterface;

interface EventDispatcherInterface
{
    /**
     * @throws \InvalidArgumentException if provider with same name already exists
     */
    public function addProvider(ProviderInterface $provider): void;

    /**
     * @throws \InvalidArgumentException if provider not found
     */
    public function removeProvider(string $providerName): void;

    /**
     * @return array<string, ProviderInterface>
     */
    public function getProviders(): array;

    /**
     * @return array<string, bool> Results indexed by provider name
     * @throws \Trovee\EventRelay\Exceptions\DispatcherException
     */
    public function dispatch(EventInterface $event): array;
} 