<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\TraditionalClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class TraditionalClientTest extends TestCase
{
    private TraditionalClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new TraditionalClient($this->http);
    }

    public function testAnalysis(): void
    {
        $this->client->getAnalysis(['subject' => $this->subject()]);

        self::assertSame('/api/v3/traditional/analysis', $this->http->lastPath);
    }

    public function testAnnualProfection(): void
    {
        $this->client->getAnnualProfection(['subject' => $this->subject()]);

        self::assertSame('/api/v3/traditional/analysis/annual-profection', $this->http->lastPath);
    }

    public function testCapabilities(): void
    {
        $this->client->getCapabilities();

        self::assertSame('/api/v3/traditional/capabilities', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    private function subject(): array
    {
        return [
            'name' => 'Traditional',
            'birth_data' => [
                'year' => 1980,
                'month' => 12,
                'day' => 25,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
