<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\PalmistryClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class PalmistryClientTest extends TestCase
{
    private PalmistryClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new PalmistryClient($this->http);
    }

    public function testGetAnalysis(): void
    {
        $this->client->getAnalysis(['image' => 'base64data']);

        self::assertSame('/api/v3/palmistry/analysis', $this->http->lastPath);
    }

    public function testGetAstroAnalysis(): void
    {
        $this->client->getAstroAnalysis(['subject' => $this->subject()]);

        self::assertSame('/api/v3/palmistry/astro-analysis', $this->http->lastPath);
    }

    public function testGetCompatibility(): void
    {
        $this->client->getCompatibility(['images' => ['img1', 'img2']]);

        self::assertSame('/api/v3/palmistry/compatibility', $this->http->lastPath);
    }

    public function testGetReading(): void
    {
        $this->client->getReading(['image' => 'base64data']);

        self::assertSame('/api/v3/palmistry/reading', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Palm User',
            'birth_data' => [
                'year' => 1992,
                'month' => 8,
                'day' => 15,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
