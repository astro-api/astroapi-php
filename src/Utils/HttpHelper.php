<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Utils;

use Procoders\AstrologyApi\Exceptions\AstrologyError;

/**
 * Abstraction for HTTP operations used by the SDK.
 */
interface HttpHelper
{
    /**
     * @param array<string, mixed>|null $query
     * @param array<string, mixed>      $options
     *
     * @throws AstrologyError
     */
    public function get(string $path, ?array $query = null, array $options = []): mixed;

    /**
     * @param array<string, mixed>|null $body
     * @param array<string, mixed>      $options
     *
     * @throws AstrologyError
     */
    public function post(string $path, ?array $body = null, array $options = []): mixed;

    /**
     * @param array<string, mixed>|null $body
     * @param array<string, mixed>      $options
     *
     * @throws AstrologyError
     */
    public function put(string $path, ?array $body = null, array $options = []): mixed;

    /**
     * @param array<string, mixed> $options
     *
     * @throws AstrologyError
     */
    public function delete(string $path, array $options = []): mixed;
}
