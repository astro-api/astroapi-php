<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\FengshuiClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class FengshuiClientTest extends TestCase
{
    private FengshuiClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new FengshuiClient($this->http);
    }

    public function testGetAfflictions(): void
    {
        $this->client->getAfflictions(2024);

        self::assertSame('/api/v3/fengshui/afflictions/2024', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testGetAnnualFlyingStars(): void
    {
        $this->client->getAnnualFlyingStars(2024);

        self::assertSame('/api/v3/fengshui/annual-flying-stars/2024', $this->http->lastPath);
    }

    public function testGetFlyingStarsChart(): void
    {
        $this->client->getFlyingStarsChart(['year' => 2024]);

        self::assertSame('/api/v3/fengshui/flying-stars-chart', $this->http->lastPath);
        self::assertSame('POST', $this->http->lastMethod);
    }

    public function testGetGlossaryStars(): void
    {
        $this->client->getGlossaryStars();

        self::assertSame('/api/v3/fengshui/glossary/stars', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }
}
