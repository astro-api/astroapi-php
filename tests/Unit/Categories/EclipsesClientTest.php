<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\EclipsesClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class EclipsesClientTest extends TestCase
{
    private EclipsesClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new EclipsesClient($this->http);
    }

    public function testUpcoming(): void
    {
        $this->client->getUpcoming(['limit' => 3]);

        self::assertSame('/api/v3/eclipses/upcoming', $this->http->lastPath);
        self::assertSame(['limit' => 3], $this->http->lastQuery);
    }

    public function testNatalCheck(): void
    {
        $this->client->checkNatalImpact(['subject' => $this->subject()]);

        self::assertSame('/api/v3/eclipses/natal-check', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Person',
            'birth_data' => [
                'year' => 1985,
                'month' => 8,
                'day' => 10,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
