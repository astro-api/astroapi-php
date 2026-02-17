<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\FixedStarsClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class FixedStarsClientTest extends TestCase
{
    private FixedStarsClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new FixedStarsClient($this->http);
    }

    public function testPositions(): void
    {
        $this->client->getPositions(['subject' => $this->subject()]);

        self::assertSame('/api/v3/fixed-stars/positions', $this->http->lastPath);
    }

    public function testPresets(): void
    {
        $this->client->getPresets();

        self::assertSame('/api/v3/fixed-stars/presets', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    private function subject(): array
    {
        return [
            'name' => 'Star',
            'birth_data' => [
                'year' => 1975,
                'month' => 11,
                'day' => 30,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
