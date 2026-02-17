<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\AstrologyClient;

final class AstrologyClientTest extends TestCase
{
    public function testHoroscopeRequestAddsApiKeyAndRetries(): void
    {
        $mock = new MockHandler([
            new Response(429, [], json_encode(['message' => 'retry'])),
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['data' => ['ok' => true]])),
        ]);

        $logs = [];
        $client = new AstrologyClient([
            'apiKey' => 'secret-key',
            'retry' => ['attempts' => 1, 'delayMs' => 0],
            'guzzleOptions' => ['handler' => HandlerStack::create($mock)],
            'debug' => true,
            'logger' => static function (string $message, array $context = []) use (&$logs): void {
                $logs[] = [$message, $context];
            },
        ]);

        $response = $client->horoscope->getSignDailyHoroscope([
            'sign' => 'Aries',
            'date' => '2024-01-01',
        ]);

        self::assertSame(['ok' => true], $response);

        $lastRequest = $mock->getLastRequest();
        self::assertSame('secret-key', $lastRequest->getHeaderLine('X-API-Key'));
        self::assertGreaterThan(0, count($logs));
    }
}
