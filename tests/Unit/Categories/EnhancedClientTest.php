<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\EnhancedClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class EnhancedClientTest extends TestCase
{
    private EnhancedClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new EnhancedClient($this->http);
    }

    public function testGlobalAnalysis(): void
    {
        $this->client->getGlobalAnalysis(['subject' => $this->subject()]);

        self::assertSame('/api/v3/enhanced/global-analysis', $this->http->lastPath);
    }

    public function testPersonalAnalysisChart(): void
    {
        $this->client->getPersonalAnalysisChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/enhanced_charts/personal-analysis', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Enhanced',
            'birth_data' => [
                'year' => 1998,
                'month' => 10,
                'day' => 3,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
