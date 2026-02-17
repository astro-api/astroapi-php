<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\PdfClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class PdfClientTest extends TestCase
{
    private PdfClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new PdfClient($this->http);
    }

    public function testGetNatalReport(): void
    {
        $this->client->getNatalReport(['subject' => $this->subject()]);

        self::assertSame('/api/v3/pdf/natal-report', $this->http->lastPath);
    }

    public function testGetDailyHoroscope(): void
    {
        $this->client->getDailyHoroscope(['sign' => 'Aries']);

        self::assertSame('/api/v3/pdf/daily-horoscope', $this->http->lastPath);
    }

    public function testGetWeeklyHoroscope(): void
    {
        $this->client->getWeeklyHoroscope(['sign' => 'Taurus']);

        self::assertSame('/api/v3/pdf/weekly-horoscope', $this->http->lastPath);
    }

    public function testGetHoroscopeData(): void
    {
        $this->client->getHoroscopeData('Aries', '2024-01-01');

        self::assertSame('/api/v3/pdf/horoscope/data/Aries/2024-01-01', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    private function subject(): array
    {
        return [
            'name' => 'PDF User',
            'birth_data' => [
                'year' => 1990,
                'month' => 3,
                'day' => 10,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
