<?php

declare(strict_types=1);

namespace Trovee\EventRelay\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Trovee\EventRelay\Contracts\ClientInterface;
use Trovee\EventRelay\Exceptions\ClientException;

/**
 * HTTP client implementation for sending requests to HTTP/HTTPS endpoints.
 * Handles request sending, response decoding, and error handling.
 */
final class HttpClient implements ClientInterface
{
    /** @var array<int, string> List of supported protocols */
    final public const SUPPORTED_PROTOCOLS = ['http', 'https'];

    /** @var Client Guzzle HTTP client instance */
    private readonly Client $client;

    public function __construct(?Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * Send HTTP request to provider endpoint.
     * 
     * @param array<string, mixed> $options Request options
     * @return array<string, mixed> Response data
     * @throws ClientException if request fails
     */
    public function send(
        string $protocol,
        string $method,
        string $endpoint,
        array $options = []
    ): array {
        $this->validateProtocol($protocol);

        try {
            $response = $this->client->request($method, $endpoint, $options);
            
            return $this->decodeResponse($response);
        } catch (GuzzleException $e) {
            throw $this->createException($e, $protocol, $method, $endpoint);
        }
    }

    /**
     * Check if given protocol is supported.
     */
    public function supports(string $protocol): bool
    {
        return in_array(strtolower($protocol), self::SUPPORTED_PROTOCOLS, strict: true);
    }

    private function validateProtocol(string $protocol): void
    {
        if (!$this->supports($protocol)) {
            throw new ClientException(
                message: sprintf('Protocol "%s" is not supported', $protocol),
                protocol: $protocol
            );
        }
    }

    /**
     * Decode response body to array.
     * 
     * @throws ClientException if response cannot be decoded
     */
    private function decodeResponse(ResponseInterface $response): array
    {
        try {
            $contents = (string) $response->getBody();
            if (empty($contents) || $contents === 'null') {
                return [];
            }
            
            $decoded = json_decode(
                $contents,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );
            
            return is_array($decoded) ? $decoded : [];
        } catch (\JsonException $e) {
            throw new ClientException(
                'Failed to decode response: ' . $e->getMessage(),
                previous: $e
            );
        }
    }

    private function createException(
        \Throwable $e,
        string $protocol,
        string $method,
        string $endpoint
    ): ClientException {
        return new ClientException(
            message: $e->getMessage(),
            protocol: $protocol,
            method: $method,
            endpoint: $endpoint,
            code: $e->getCode(),
            previous: $e
        );
    }
} 