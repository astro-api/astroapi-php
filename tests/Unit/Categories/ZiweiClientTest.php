<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\ZiweiClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class ZiweiClientTest extends TestCase
{
    private ZiweiClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new ZiweiClient($this->http);
    }

    public function testGetChart(): void
    {
        $this->client->getChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/ziwei/chart', $this->http->lastPath);
        self::assertSame('POST', $this->http->lastMethod);
    }

    private function subject(): array
    {
        return [
            'name' => 'Ziwei User',
            'birth_data' => [
                'year' => 1993,
                'month' => 2,
                'day' => 14,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
