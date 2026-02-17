<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Exceptions;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 * Domain specific exception for the Astrology API SDK.
 */
class AstrologyError extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly ?int $statusCode = null,
        public readonly ?string $errorCode = null,
        public readonly mixed $details = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }

    public static function fromGuzzleException(GuzzleException $exception): self
    {
        $statusCode = null;
        $errorCode = null;
        $details = null;
        $message = $exception->getMessage();

        if ($exception instanceof RequestException) {
            $response = $exception->getResponse();
            if ($response instanceof ResponseInterface) {
                $statusCode = $response->getStatusCode();
                $details = self::decodeResponseBody($response);
                $errorCode = self::extractErrorCode($details) ?? (string) $exception->getCode();
                $message = self::extractMessage($details) ?? $message;
            }
        }

        return new self($message, $statusCode, $errorCode, $details, $exception);
    }

    public static function normalize(Throwable $throwable): self
    {
        if ($throwable instanceof self) {
            return $throwable;
        }

        if ($throwable instanceof GuzzleException) {
            return self::fromGuzzleException($throwable);
        }

        return new self($throwable->getMessage(), details: null, previous: $throwable);
    }

    public function isClientError(): bool
    {
        return $this->statusCode !== null && $this->statusCode >= 400 && $this->statusCode < 500;
    }

    public function isServerError(): bool
    {
        return $this->statusCode !== null && $this->statusCode >= 500;
    }

    private static function decodeResponseBody(ResponseInterface $response): mixed
    {
        $body = (string) $response->getBody();
        if ($body === '') {
            return null;
        }

        $contentType = strtolower($response->getHeaderLine('Content-Type'));
        if (!str_contains($contentType, 'application/json')) {
            return $body;
        }

        $decoded = json_decode($body, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $body;
    }

    private static function extractErrorCode(mixed $details): ?string
    {
        if (!is_array($details)) {
            return null;
        }

        return isset($details['code']) ? (string) $details['code'] : null;
    }

    private static function extractMessage(mixed $details): ?string
    {
        if (is_array($details) && isset($details['message'])) {
            return (string) $details['message'];
        }

        return null;
    }
}
