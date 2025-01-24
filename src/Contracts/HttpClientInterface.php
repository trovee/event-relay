<?php

namespace Trovee\EventRelay\Contracts;

interface HttpClientInterface
{
    /**
     * HTTP request gönder
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $endpoint API endpoint
     * @param array $options Request options (headers, query, json, etc.)
     * @return array Response data
     * @throws \KaracaTech\EventTracker\Exceptions\HttpException
     */
    public function request(string $method, string $endpoint, array $options = []): array;
}