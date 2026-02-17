<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\ChartsClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class ChartsClientTest extends TestCase
{
    private ChartsClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new ChartsClient($this->http);
    }

    public function testNatalChart(): void
    {
        $this->client->getNatalChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/charts/natal', $this->http->lastPath);
    }

    public function testSynastryChart(): void
    {
        $this->client->getSynastryChart([
            'subject1' => $this->subject(),
            'subject2' => $this->subject(),
        ]);

        self::assertSame('/api/v3/charts/synastry', $this->http->lastPath);
    }

    public function testTransitChart(): void
    {
        $this->client->getTransitChart([
            'natal_subject' => $this->subject(),
            'transit_datetime' => $this->dateTimeLocation(),
        ]);

        self::assertSame('/api/v3/charts/transit', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Sample',
            'birth_data' => [
                'year' => 1988,
                'month' => 1,
                'day' => 2,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }

    public function testVenusReturnChart(): void
    {
        $this->client->getVenusReturnChart([
            'subject' => $this->subject(),
            'return_year' => 2024,
        ]);

        self::assertSame('/api/v3/charts/venus-return', $this->http->lastPath);
    }

    public function testVenusReturnTransits(): void
    {
        $this->client->getVenusReturnTransits([
            'subject' => $this->subject(),
            'return_year' => 2024,
            'date_range' => ['start' => '2024-01-01', 'end' => '2024-12-31'],
            'orb' => 1.5,
        ]);

        self::assertSame('/api/v3/charts/venus-return-transits', $this->http->lastPath);
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
