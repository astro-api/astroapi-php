<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\AnalysisClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class AnalysisClientTest extends TestCase
{
    private AnalysisClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new AnalysisClient($this->http);
    }

    public function testNatalReport(): void
    {
        $this->client->getNatalReport(['subject' => $this->subject()]);

        self::assertSame('/api/v3/analysis/natal-report', $this->http->lastPath);
    }

    public function testCompatibilityAnalysis(): void
    {
        $this->client->getCompatibilityAnalysis(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/analysis/compatibility', $this->http->lastPath);
    }

    public function testSolarReturnReport(): void
    {
        $this->client->getSolarReturnReport([
            'subject' => $this->subject(),
            'return_year' => 2024,
        ]);

        self::assertSame('/api/v3/analysis/solar-return-report', $this->http->lastPath);
    }

    public function testVenusReturnReport(): void
    {
        $this->client->getVenusReturnReport([
            'subject' => $this->subject(),
            'return_year' => 2024,
        ]);

        self::assertSame('/api/v3/analysis/venus-return-report', $this->http->lastPath);
    }

    public function testVenusReturnTransitReport(): void
    {
        $this->client->getVenusReturnTransitReport([
            'subject' => $this->subject(),
            'return_year' => 2024,
            'date_range' => ['start' => '2024-01-01', 'end' => '2024-12-31'],
            'orb' => 1.0,
        ]);

        self::assertSame('/api/v3/analysis/venus-return-transit-report', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Sample',
            'birth_data' => [
                'year' => 1991,
                'month' => 7,
                'day' => 12,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
