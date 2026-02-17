<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Support;

use Procoders\AstrologyApi\Utils\HttpHelper;

final class SpyHttpHelper implements HttpHelper
{
    public string $lastMethod = '';
    public string $lastPath = '';
    public array|null $lastPayload = null;
    public array $lastOptions = [];
    public array|null $lastQuery = null;
    public mixed $response;

    public function __construct(mixed $response = null)
    {
        $this->response = $response ?? ['ok' => true];
    }

    public function get(string $path, ?array $query = null, array $options = []): mixed
    {
        $this->record('GET', $path, null, $query, $options);

        return $this->response;
    }

    public function post(string $path, ?array $body = null, array $options = []): mixed
    {
        $this->record('POST', $path, $body, null, $options);

        return $this->response;
    }

    public function put(string $path, ?array $body = null, array $options = []): mixed
    {
        $this->record('PUT', $path, $body, null, $options);

        return $this->response;
    }

    public function delete(string $path, array $options = []): mixed
    {
        $this->record('DELETE', $path, null, null, $options);

        return $this->response;
    }

    private function record(string $method, string $path, ?array $payload, ?array $query, array $options): void
    {
        $this->lastMethod = $method;
        $this->lastPath = $path;
        $this->lastPayload = $payload;
        $this->lastQuery = $query;
        $this->lastOptions = $options;
    }
}
