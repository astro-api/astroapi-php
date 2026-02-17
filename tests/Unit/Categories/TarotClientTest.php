<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\TarotClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class TarotClientTest extends TestCase
{
    private TarotClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new TarotClient($this->http);
    }

    public function testDrawCards(): void
    {
        $this->client->drawCards(['cards' => 3]);

        self::assertSame('/api/v3/tarot/cards/draw', $this->http->lastPath);
    }

    public function testSingleReport(): void
    {
        $this->client->generateSingleReport([
            'subjects' => [$this->subject(), $this->subject()],
        ]);

        self::assertSame('/api/v3/tarot/reports/single', $this->http->lastPath);
    }

    public function testDailyCardQuery(): void
    {
        $this->client->getDailyCard(['sign' => 'Aries']);

        self::assertSame('/api/v3/tarot/cards/daily', $this->http->lastPath);
        self::assertSame(['sign' => 'Aries'], $this->http->lastQuery);
    }

    private function subject(): array
    {
        return [
            'name' => 'Tarot User',
            'birth_data' => [
                'year' => 1993,
                'month' => 9,
                'day' => 9,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
