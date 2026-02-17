<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Exceptions\AstrologyError;

/**
 * Base class shared by all category clients. Handles URL prefixing and exposes the HTTP helper.
 */
abstract class BaseCategoryClient
{
    private readonly string $prefix;

    public function __construct(protected readonly HttpHelper $http, string $apiPrefix)
    {
        $this->prefix = $this->normalizePrefix($apiPrefix);
    }

    protected function buildUrl(string ...$segments): string
    {
        $parts = array_filter(array_map($this->stripSlashes(...), $segments), static fn (string $segment): bool => $segment !== '');
        $path = implode('/', $parts);

        if ($path === '') {
            return $this->prefix;
        }

        return sprintf('%s/%s', $this->prefix, $path);
    }

    protected function buildCustomUrl(string $prefix, string ...$segments): string
    {
        $normalizedPrefix = $this->normalizePrefix($prefix);
        $parts = array_filter(array_map($this->stripSlashes(...), $segments), static fn (string $segment): bool => $segment !== '');
        $path = implode('/', $parts);

        if ($path === '') {
            return $normalizedPrefix;
        }

        return sprintf('%s/%s', $normalizedPrefix, $path);
    }

    private function normalizePrefix(string $prefix): string
    {
        $trimmed = trim($prefix);
        if ($trimmed === '') {
            throw new AstrologyError('API prefix must be a non-empty string.');
        }

        if ($trimmed[0] !== '/') {
            throw new AstrologyError('API prefix must start with a forward slash.');
        }

        $normalized = '/' . ltrim($trimmed, '/');
        return rtrim($normalized, '/');
    }

    private function stripSlashes(string $segment): string
    {
        return trim($segment, '/');
    }
}
