<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\ChineseClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class ChineseClientTest extends TestCase
{
    private ChineseClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new ChineseClient($this->http);
    }

    public function testBaZi(): void
    {
        $this->client->calculateBaZi(['subject' => $this->subject()]);

        self::assertSame('/api/v3/chinese/bazi', $this->http->lastPath);
    }

    public function testYearlyForecast(): void
    {
        $this->client->getYearlyForecast(['subject' => $this->subject()]);

        self::assertSame('/api/v3/chinese/yearly-forecast', $this->http->lastPath);
    }

    public function testZodiacAnimal(): void
    {
        $this->client->getZodiacAnimal('dragon');

        self::assertSame('/api/v3/chinese/zodiac/dragon', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'User',
            'birth_data' => [
                'year' => 1990,
                'month' => 6,
                'day' => 15,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
