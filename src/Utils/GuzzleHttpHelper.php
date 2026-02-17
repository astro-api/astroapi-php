<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Utils;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Procoders\AstrologyApi\Exceptions\AstrologyError;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * HTTP helper backed by Guzzle that normalises request and response handling.
 */
final class GuzzleHttpHelper implements HttpHelper
{
    public function __construct(private readonly ClientInterface $client)
    {
    }

    public function get(string $path, ?array $query = null, array $options = []): mixed
    {
        $requestOptions = $this->mergeOptions($options, [
            RequestOptions::QUERY => $query,
        ]);

        return $this->send('GET', $path, $requestOptions);
    }

    public function post(string $path, ?array $body = null, array $options = []): mixed
    {
        $requestOptions = $this->mergeOptions($options, [
            RequestOptions::JSON => $body,
        ]);

        return $this->send('POST', $path, $requestOptions);
    }

    public function put(string $path, ?array $body = null, array $options = []): mixed
    {
        $requestOptions = $this->mergeOptions($options, [
            RequestOptions::JSON => $body,
        ]);

        return $this->send('PUT', $path, $requestOptions);
    }

    public function delete(string $path, array $options = []): mixed
    {
        return $this->send('DELETE', $path, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    private function send(string $method, string $path, array $options): mixed
    {
        try {
            $response = $this->client->request($method, $path, $options);
        } catch (GuzzleException $exception) {
            throw AstrologyError::fromGuzzleException($exception);
        } catch (Throwable $exception) {
            throw AstrologyError::normalize($exception);
        }

        return $this->normalizeResponse($response);
    }

    /**
     * @param array<string, mixed> $primary
     * @param array<string, mixed> $secondary
     *
     * @return array<string, mixed>
     */
    private function mergeOptions(array $primary, array $secondary): array
    {
        foreach ($secondary as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (!array_key_exists($key, $primary)) {
                $primary[$key] = $value;
                continue;
            }

            if (is_array($primary[$key]) && is_array($value)) {
                $primary[$key] = array_merge($value, $primary[$key]);
                continue;
            }
        }

        return $primary;
    }

    private function normalizeResponse(ResponseInterface $response): mixed
    {
        $body = (string) $response->getBody();

        if ($body === '') {
            return null;
        }

        $contentType = strtolower($response->getHeaderLine('Content-Type'));
        $payload = $body;

        if (str_contains($contentType, 'application/json')) {
            $decoded = json_decode($body, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $payload = $decoded;
            }
        }

        if (is_array($payload)) {
            if (array_key_exists('data', $payload)) {
                return $payload['data'];
            }

            if (array_key_exists('result', $payload)) {
                return $payload['result'];
            }
        }

        return $payload;
    }
}
