<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\AstrologyClient;

abstract class IntegrationTestCase extends TestCase
{
    protected static ?AstrologyClient $client = null;

    protected function setUp(): void
    {
        parent::setUp();

        $apiKey = getenv('ASTROLOGY_API_KEY');

        if (empty($apiKey)) {
            $this->markTestSkipped('ASTROLOGY_API_KEY not set — skipping integration test.');
        }

        if (self::$client === null) {
            self::$client = new AstrologyClient([
                'apiKey' => $apiKey,
            ]);
        }
    }

    protected function subject(): array
    {
        return [
            'name' => 'Integration Test',
            'birth_data' => [
                'year' => 1990,
                'month' => 6,
                'day' => 15,
                'hour' => 12,
                'minute' => 30,
                'second' => 0,
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'city' => 'New York',
                'nation' => 'US',
                'timezone' => 'America/New_York',
            ],
        ];
    }

    protected function secondSubject(): array
    {
        return [
            'name' => 'Integration Test 2',
            'birth_data' => [
                'year' => 1988,
                'month' => 3,
                'day' => 22,
                'hour' => 8,
                'minute' => 15,
                'second' => 0,
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'city' => 'London',
                'nation' => 'GB',
                'timezone' => 'Europe/London',
            ],
        ];
    }

    protected function dateTimeLocation(): array
    {
        return [
            'year' => 2024,
            'month' => 6,
            'day' => 1,
            'hour' => 12,
            'minute' => 0,
            'second' => 0,
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ];
    }

    protected function assertSuccessResponse(mixed $response): void
    {
        self::assertNotNull($response, 'API response should not be null');
        self::assertIsArray($response, 'API response should be an array');
    }
}
