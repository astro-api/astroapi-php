<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\HoraryClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class HoraryClientTest extends TestCase
{
    private HoraryClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new HoraryClient($this->http);
    }

    public function testAnalyze(): void
    {
        $this->client->analyze(['question' => 'Will I get the job?']);

        self::assertSame('/api/v3/horary/analyze', $this->http->lastPath);
    }

    public function testGetAspects(): void
    {
        $this->client->getAspects(['chart_data' => []]);

        self::assertSame('/api/v3/horary/aspects', $this->http->lastPath);
    }

    public function testGetChart(): void
    {
        $this->client->getChart(['question' => 'When?']);

        self::assertSame('/api/v3/horary/chart', $this->http->lastPath);
    }

    public function testGetFertilityAnalysis(): void
    {
        $this->client->getFertilityAnalysis(['subject' => $this->subject()]);

        self::assertSame('/api/v3/horary/fertility', $this->http->lastPath);
    }

    public function testGetGlossaryCategories(): void
    {
        $this->client->getGlossaryCategories();

        self::assertSame('/api/v3/horary/glossary/categories', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testGetGlossaryConsiderations(): void
    {
        $this->client->getGlossaryConsiderations();

        self::assertSame('/api/v3/horary/glossary/considerations', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Horary User',
            'birth_data' => [
                'year' => 1995,
                'month' => 6,
                'day' => 20,
                'hour' => 12,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
