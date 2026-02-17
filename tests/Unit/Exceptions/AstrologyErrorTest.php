<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Exceptions;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Exceptions\AstrologyError;

final class AstrologyErrorTest extends TestCase
{
    public function testFromGuzzleExceptionExtractsInformation(): void
    {
        $request = new Request('GET', '/test');
        $response = new Response(429, ['Content-Type' => 'application/json'], json_encode(['message' => 'Too many', 'code' => 'rate_limit']));
        $exception = new RequestException('error', $request, $response);

        $error = AstrologyError::fromGuzzleException($exception);

        self::assertSame('Too many', $error->getMessage());
        self::assertSame(429, $error->statusCode);
        self::assertSame('rate_limit', $error->errorCode);
        self::assertTrue($error->isClientError());
        self::assertFalse($error->isServerError());
    }

    public function testNormalizeWrapsGenericThrowable(): void
    {
        $normalized = AstrologyError::normalize(new \RuntimeException('boom'));

        self::assertInstanceOf(AstrologyError::class, $normalized);
        self::assertSame('boom', $normalized->getMessage());
    }

    public function testNormalizeReturnsExistingAstrologyError(): void
    {
        $error = new AstrologyError('existing', 503);

        self::assertSame($error, AstrologyError::normalize($error));
        self::assertTrue($error->isServerError());
    }
}
