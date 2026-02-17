<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Config;

use Psr\Log\LoggerInterface;

/**
 * Normalised configuration container for the Astrology API client.
 */
final class AstrologyClientConfig
{
    public const DEFAULT_BASE_URL = 'https://api.astrology-api.io';
    public const DEFAULT_TIMEOUT_MS = 10_000;
    /**
     * @var int[]
     */
    public const DEFAULT_RETRY_STATUS_CODES = [408, 425, 429, 500, 502, 503, 504];

    /**
     * @param callable(string, array):void|null $logger
     * @param array<string, mixed>              $guzzleOptions
     */
    private function __construct(
        public readonly ?string $apiKey,
        public readonly string $baseUrl,
        public readonly int $timeoutMs,
        public readonly RetryConfig $retry,
        public readonly bool $debug,
        /** @var callable(string, array):void|null */
        public readonly mixed $logger,
        public readonly array $guzzleOptions,
    ) {
    }

    /**
     * @param array<string, mixed> $config
     */
    public static function fromArray(array $config = []): self
    {
        $apiKey = self::resolveApiKey($config['apiKey'] ?? null);
        $baseUrl = self::resolveBaseUrl($config['baseUrl'] ?? null, $config['baseURL'] ?? null);
        $timeout = self::resolveTimeout($config['timeout'] ?? null);
        $debug = self::resolveDebugFlag($config['debug'] ?? null);
        $logger = self::resolveLogger($config['logger'] ?? null);
        $guzzleOptions = self::resolveGuzzleOptions($config['guzzleOptions'] ?? $config['http'] ?? []);
        $retry = self::resolveRetryConfig($config['retry'] ?? []);

        return new self(
            $apiKey,
            $baseUrl,
            $timeout,
            $retry,
            $debug,
            $logger,
            $guzzleOptions,
        );
    }

    private static function resolveApiKey(?string $apiKey): ?string
    {
        $candidate = trim((string) ($apiKey ?? ''));
        if ($candidate !== '') {
            return $candidate;
        }

        $env = getenv('ASTROLOGY_API_KEY');
        if (is_string($env)) {
            $env = trim($env);
            if ($env !== '') {
                return $env;
            }
        }

        return null;
    }

    private static function resolveBaseUrl(?string $baseUrl, ?string $baseURL): string
    {
        foreach ([$baseUrl, $baseURL, getenv('ASTROLOGY_API_BASE_URL')] as $candidate) {
            if (!is_string($candidate)) {
                continue;
            }

            $trimmed = trim($candidate);
            if ($trimmed !== '') {
                return rtrim($trimmed, '/');
            }
        }

        return self::DEFAULT_BASE_URL;
    }

    private static function resolveTimeout(null|int|string $timeout): int
    {
        if (is_int($timeout) && $timeout > 0) {
            return $timeout;
        }

        if (is_string($timeout) && ctype_digit($timeout)) {
            $value = (int) $timeout;
            if ($value > 0) {
                return $value;
            }
        }

        return self::DEFAULT_TIMEOUT_MS;
    }

    private static function resolveDebugFlag(null|bool|string $flag): bool
    {
        if (is_bool($flag)) {
            return $flag;
        }

        $candidate = $flag ?? getenv('ASTROLOGY_DEBUG');
        if (is_string($candidate) && $candidate !== '') {
            return in_array(strtolower($candidate), ['1', 'true', 'on', 'yes'], true);
        }

        return false;
    }

    /**
     * @param mixed $logger
     *
     * @return callable(string, array):void|null
     */
    private static function resolveLogger(mixed $logger): ?callable
    {
        if ($logger instanceof LoggerInterface) {
            return static function (string $message, array $context = []) use ($logger): void {
                $logger->info($message, $context);
            };
        }

        if (is_callable($logger)) {
            return static function (string $message, array $context = []) use ($logger): void {
                $logger($message, $context);
            };
        }

        return null;
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    private static function resolveGuzzleOptions(array $options): array
    {
        return $options;
    }

    /**
     * @param array<string, mixed> $retry
     */
    private static function resolveRetryConfig(array $retry): RetryConfig
    {
        $attempts = max(0, (int) ($retry['attempts'] ?? 0));
        $delayMs = max(0, (int) ($retry['delayMs'] ?? $retry['delay_ms'] ?? 250));
        $statusCodes = $retry['retryStatusCodes'] ?? $retry['statusCodes'] ?? null;

        if (is_array($statusCodes) && count($statusCodes) > 0) {
            $normalized = array_values(array_unique(array_map(static fn ($code): int => (int) $code, $statusCodes)));
        } else {
            $normalized = self::DEFAULT_RETRY_STATUS_CODES;
        }

        return new RetryConfig($attempts, $delayMs, $normalized);
    }
}
