<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\DataClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class DataClientTest extends TestCase
{
    private DataClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new DataClient($this->http);
    }

    public function testPositionsEndpoint(): void
    {
        $this->client->getPositions(['subject' => $this->subject()]);

        self::assertSame('/api/v3/data/positions', $this->http->lastPath);
        self::assertSame('POST', $this->http->lastMethod);
    }

    public function testGlobalPositionsUsesPost(): void
    {
        $this->client->getGlobalPositions([
            'year' => 2024,
            'month' => 1,
            'day' => 10,
            'hour' => 0,
            'minute' => 0,
            'second' => 0,
        ]);

        self::assertSame('/api/v3/data/global-positions', $this->http->lastPath);
    }

    public function testCurrentMomentUsesGet(): void
    {
        $this->client->getCurrentMoment();

        self::assertSame('/api/v3/data/now', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    private function subject(): array
    {
        return [
            'name' => 'User',
            'birth_data' => [
                'year' => 1990,
                'month' => 5,
                'day' => 20,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
