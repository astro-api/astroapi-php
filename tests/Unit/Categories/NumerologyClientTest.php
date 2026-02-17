<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\NumerologyClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class NumerologyClientTest extends TestCase
{
    private NumerologyClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new NumerologyClient($this->http);
    }

    public function testCoreNumbers(): void
    {
        $this->client->getCoreNumbers(['subject' => $this->subject()]);

        self::assertSame('/api/v3/numerology/core-numbers', $this->http->lastPath);
    }

    public function testCompatibility(): void
    {
        $this->client->analyzeCompatibility(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/numerology/compatibility', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Example',
            'birth_data' => [
                'year' => 1995,
                'month' => 3,
                'day' => 10,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
