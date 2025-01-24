<?php

namespace Trovee\EventRelay\Contracts;

interface HttpClientInterface
{
    /**
     * Send HTTP request
     *
     * @param string $method
     * @param string $endpoint
     * @param array<string, mixed> $options
     * @return array<string, mixed>
     * @throws \Trovee\EventRelay\Exceptions\HttpException
     */
    public function request(string $method, string $endpoint, array $options = []): array;
}