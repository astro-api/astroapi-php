<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\SvgClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class SvgClientTest extends TestCase
{
    private SvgClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new SvgClient($this->http);
    }

    public function testNatalSvg(): void
    {
        $this->client->getNatalChartSvg(['subject' => $this->subject()]);

        self::assertSame('/api/v3/svg/natal', $this->http->lastPath);
    }

    public function testSynastrySvg(): void
    {
        $this->client->getSynastryChartSvg(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/svg/synastry', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'SVG',
            'birth_data' => [
                'year' => 1994,
                'month' => 6,
                'day' => 6,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
