<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\LunarClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class LunarClientTest extends TestCase
{
    private LunarClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new LunarClient($this->http);
    }

    public function testPhases(): void
    {
        $this->client->getPhases(['datetime_location' => $this->dateTimeLocation()]);

        self::assertSame('/api/v3/lunar/phases', $this->http->lastPath);
    }

    public function testVoidOfCourse(): void
    {
        $this->client->getVoidOfCourse(['datetime_location' => $this->dateTimeLocation()]);

        self::assertSame('/api/v3/lunar/void-of-course', $this->http->lastPath);
    }

    public function testCalendar(): void
    {
        $this->client->getCalendar(2024, ['hemisphere' => 'north']);

        self::assertSame('/api/v3/lunar/calendar/2024', $this->http->lastPath);
        self::assertSame(['hemisphere' => 'north'], $this->http->lastQuery);
    }

    private function dateTimeLocation(): array
    {
        return [
            'year' => 2024,
            'month' => 1,
            'day' => 1,
            'hour' => 0,
            'minute' => 0,
            'second' => 0,
        ];
    }
}
