<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{
    EventInterface,
    ProviderInterface,
    EventMapperInterface,
    ClientInterface
};
use Trovee\EventRelay\Exceptions\{ProviderException, ValidationException};

/**
 * Base class for providers that handle sending events to specific services.
 * Implements common provider functionality and defines abstract methods for specific implementations.
 */
abstract class AbstractProvider implements ProviderInterface
{
    /** @var array<string, mixed> */
    private readonly array $config;

    public function __construct(
        protected readonly EventMapperInterface $mapper,
        protected readonly ClientInterface $client,
        array $config = []
    ) {
        $this->config = $this->validateConfig($config);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function send(EventInterface $event): bool
    {
        if (!$this->supports($event)) {
            return false;
        }

        try {
            $this->validateEventData($event->getData());
            return $this->sendToProvider($event);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new ProviderException(
                $e->getMessage(),
                $this->getName(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     * @throws ValidationException
     */
    abstract protected function validateConfig(array $config): array;

    /**
     * Validate event data before sending to provider
     * 
     * @param array<string, mixed> $data
     * @throws ValidationException if data is invalid
     */
    protected function validateEventData(array $data): void
    {
        // Override this method to add custom validation
    }

    /**
     * Send event to provider implementation
     * 
     * @throws \Throwable if any unexpected error occurs
     * @throws \Trovee\EventRelay\Exceptions\ProviderException if provider-specific error occurs
     * @throws \Trovee\EventRelay\Exceptions\ValidationException if validation fails
     */
    abstract protected function sendToProvider(EventInterface $event): bool;
} 