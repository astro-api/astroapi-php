<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\HealthClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class HealthClientTest extends TestCase
{
    private HealthClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new HealthClient($this->http);
    }

    public function testCheck(): void
    {
        $this->client->check();

        self::assertSame('/api/v3/health', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testDebugTimezone(): void
    {
        $this->client->debugTimezone();

        self::assertSame('/api/v3/health/debug/timezone', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }
}
