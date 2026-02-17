<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\HoroscopeClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class HoroscopeClientTest extends TestCase
{
    private HoroscopeClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper(['ok' => true]);
        $this->client = new HoroscopeClient($this->http);
    }

    public function testPersonalDaily(): void
    {
        $this->client->getPersonalDailyHoroscope([
            'subject' => $this->subject(),
        ]);

        self::assertSame('/api/v3/horoscope/personal/daily', $this->http->lastPath);
    }

    public function testSignDaily(): void
    {
        $this->client->getSignDailyHoroscope([
            'sign' => 'Aries',
            'date' => '2024-01-01',
        ]);

        self::assertSame('/api/v3/horoscope/sign/daily', $this->http->lastPath);
    }

    public function testOtherEndpoints(): void
    {
        $this->client->getPersonalDailyHoroscopeText(['subject' => $this->subject()]);
        self::assertSame('/api/v3/horoscope/personal/daily/text', $this->http->lastPath);

        $this->client->getSignDailyHoroscopeText(['sign' => 'Tau']);
        self::assertSame('/api/v3/horoscope/sign/daily/text', $this->http->lastPath);

        $this->client->getSignWeeklyHoroscope(['sign' => 'Gem', 'start_date' => '2024-01-01']);
        self::assertSame('/api/v3/horoscope/sign/weekly', $this->http->lastPath);

        $this->client->getSignWeeklyHoroscopeText(['sign' => 'Can']);
        self::assertSame('/api/v3/horoscope/sign/weekly/text', $this->http->lastPath);

        $this->client->getSignMonthlyHoroscope(['sign' => 'Leo', 'month' => '2024-01']);
        self::assertSame('/api/v3/horoscope/sign/monthly', $this->http->lastPath);

        $this->client->getSignMonthlyHoroscopeText(['sign' => 'Vir', 'month' => '2024-02']);
        self::assertSame('/api/v3/horoscope/sign/monthly/text', $this->http->lastPath);

        $this->client->getSignYearlyHoroscope(['sign' => 'Lib']);
        self::assertSame('/api/v3/horoscope/sign/yearly', $this->http->lastPath);
    }

    public function testChineseHoroscope(): void
    {
        $this->client->getChineseHoroscope([
            'subject' => ['birth_data' => $this->birthData()],
        ]);

        self::assertSame('/api/v3/horoscope/chinese/bazi', $this->http->lastPath);
    }

    public function testSignYearlyHoroscopeText(): void
    {
        $this->client->getSignYearlyHoroscopeText(['sign' => 'Aries']);

        self::assertSame('/api/v3/horoscope/sign/yearly/text', $this->http->lastPath);
    }

    public function testPersonalWeeklyHoroscope(): void
    {
        $this->client->getPersonalWeeklyHoroscope(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horoscope/personal/weekly', $this->http->lastPath);
    }

    public function testPersonalWeeklyHoroscopeText(): void
    {
        $this->client->getPersonalWeeklyHoroscopeText(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horoscope/personal/weekly/text', $this->http->lastPath);
    }

    public function testPersonalMonthlyHoroscope(): void
    {
        $this->client->getPersonalMonthlyHoroscope(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horoscope/personal/monthly', $this->http->lastPath);
    }

    public function testPersonalMonthlyHoroscopeText(): void
    {
        $this->client->getPersonalMonthlyHoroscopeText(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horoscope/personal/monthly/text', $this->http->lastPath);
    }

    public function testPersonalYearlyHoroscope(): void
    {
        $this->client->getPersonalYearlyHoroscope(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horoscope/personal/yearly', $this->http->lastPath);
    }

    public function testPersonalYearlyHoroscopeText(): void
    {
        $this->client->getPersonalYearlyHoroscopeText(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horoscope/personal/yearly/text', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Test',
            'birth_data' => $this->birthData(),
        ];
    }

    private function birthData(): array
    {
        return [
            'year' => 1990,
            'month' => 1,
            'day' => 1,
            'hour' => 0,
            'minute' => 0,
            'second' => 0,
        ];
    }
}
