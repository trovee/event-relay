<?php

namespace Trovee\EventRelay\Abstracts;

use Trovee\EventRelay\Contracts\{
    EventInterface,
    ProviderInterface,
    EventMapperInterface,
    HttpClientInterface
};
use Trovee\EventRelay\Exceptions\{ProviderException, ValidationException};

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $config = [];

    public function __construct(
        protected readonly EventMapperInterface $mapper,
        protected readonly HttpClientInterface $httpClient,
        array $config = []
    ) {
        $this->config = $this->validateConfig($config);
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
        } catch (\Exception $e) {
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
     * @param array<string, mixed> $data
     * @throws ValidationException
     */
    abstract protected function validateEventData(array $data): void;

    /**
     * @throws \Exception
     */
    abstract protected function sendToProvider(EventInterface $event): bool;
} 