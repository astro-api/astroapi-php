<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Config;

/**
 * Immutable value object describing retry behaviour for HTTP requests.
 */
final class RetryConfig
{
    private const MIN_DELAY_MS = 0;

    /**
     * @param int   $attempts     Number of retry attempts to perform after the initial request.
     * @param int   $delayMs      Delay in milliseconds between attempts.
     * @param int[] $statusCodes  HTTP status codes that should trigger a retry.
     */
    public function __construct(
        public readonly int $attempts,
        public readonly int $delayMs,
        public readonly array $statusCodes,
    ) {
        if ($this->attempts < 0) {
            throw new \InvalidArgumentException('Retry attempts must be greater than or equal to zero.');
        }

        if ($this->delayMs < self::MIN_DELAY_MS) {
            throw new \InvalidArgumentException('Retry delay must be zero or greater.');
        }

        foreach ($this->statusCodes as $code) {
            if ($code < 100 || $code > 599) {
                throw new \InvalidArgumentException('Retry status codes must be valid HTTP status codes.');
            }
        }
    }
}
