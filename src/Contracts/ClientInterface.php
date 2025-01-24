<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Contracts;

interface ClientInterface
{
    /**
     * Send request to provider
     *
     * @param string $protocol Protocol to use (http, https, tcp, udp, etc.)
     * @param string $method Request method (GET, POST, etc. for HTTP)
     * @param string $endpoint Target endpoint
     * @param array<string, mixed> $options Request options
     * @return array<string, mixed> Response data
     * @throws \Trovee\EventRelay\Exceptions\ClientException
     */
    public function send(string $protocol, string $method, string $endpoint, array $options = []): array;

    /**
     * Check if protocol is supported
     */
    public function supports(string $protocol): bool;
} 