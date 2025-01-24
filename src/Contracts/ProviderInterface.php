<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Contracts;

interface ProviderInterface
{
    public function getName(): string;
    
    /**
     * @throws \Trovee\EventRelay\Exceptions\ProviderException
     * @throws \Trovee\EventRelay\Exceptions\ValidationException
     */
    public function send(EventInterface $event): bool;
    
    public function supports(EventInterface $event): bool;
}