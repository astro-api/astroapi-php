<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\VedicClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class VedicClientTest extends TestCase
{
    private VedicClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new VedicClient($this->http);
    }

    public function testGetChart(): void
    {
        $this->client->getChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/chart', $this->http->lastPath);
    }

    public function testGetBirthDetails(): void
    {
        $this->client->getBirthDetails(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/birth-details', $this->http->lastPath);
    }

    public function testGetPanchang(): void
    {
        $this->client->getPanchang(['date' => '2024-01-01']);

        self::assertSame('/api/v3/vedic/panchang', $this->http->lastPath);
    }

    public function testGetRegionalPanchang(): void
    {
        $this->client->getRegionalPanchang(['date' => '2024-01-01', 'region' => 'north']);

        self::assertSame('/api/v3/vedic/panchang/regional', $this->http->lastPath);
    }

    public function testGetKundliMatching(): void
    {
        $this->client->getKundliMatching(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/vedic/kundli-matching', $this->http->lastPath);
    }

    public function testGetManglikDosha(): void
    {
        $this->client->getManglikDosha(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/manglik-dosha', $this->http->lastPath);
    }

    public function testGetVimshottariDasha(): void
    {
        $this->client->getVimshottariDasha(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/vimshottari-dasha', $this->http->lastPath);
    }

    public function testGetYoginiDasha(): void
    {
        $this->client->getYoginiDasha(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/yogini-dasha', $this->http->lastPath);
    }

    public function testGetCharaDasha(): void
    {
        $this->client->getCharaDasha(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/chara-dasha', $this->http->lastPath);
    }

    public function testGetNakshatraPredictions(): void
    {
        $this->client->getNakshatraPredictions(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/nakshatra-predictions', $this->http->lastPath);
    }

    public function testGetShadbala(): void
    {
        $this->client->getShadbala(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/shadbala', $this->http->lastPath);
    }

    public function testGetAshtakvarga(): void
    {
        $this->client->getAshtakvarga(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/ashtakvarga', $this->http->lastPath);
    }

    public function testGetKPSystem(): void
    {
        $this->client->getKPSystem(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/kp-system', $this->http->lastPath);
    }

    public function testGetRemedies(): void
    {
        $this->client->getRemedies(['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/remedies', $this->http->lastPath);
    }

    public function testRenderChart(): void
    {
        $this->client->renderChart('svg', ['subject' => $this->subject()]);

        self::assertSame('/api/v3/vedic/chart/render/svg', $this->http->lastPath);
    }

    public function testGetFestivalCalendar(): void
    {
        $this->client->getFestivalCalendar(['year' => 2024]);

        self::assertSame('/api/v3/vedic/festival-calendar', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Vedic User',
            'birth_data' => [
                'year' => 1990,
                'month' => 5,
                'day' => 15,
                'hour' => 10,
                'minute' => 30,
                'second' => 0,
            ],
        ];
    }
}
