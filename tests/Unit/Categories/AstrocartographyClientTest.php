<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\AstrocartographyClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class AstrocartographyClientTest extends TestCase
{
    private AstrocartographyClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new AstrocartographyClient($this->http);
    }

    public function testLines(): void
    {
        $this->client->getLines(['subject' => $this->subject()]);

        self::assertSame('/api/v3/astrocartography/lines', $this->http->lastPath);
    }

    public function testRelocationChart(): void
    {
        $this->client->generateRelocationChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/astrocartography/relocation-chart', $this->http->lastPath);
    }

    public function testAstrodynes(): void
    {
        $this->client->getAstrodynes(['subject' => $this->subject()]);

        self::assertSame('/api/v3/astrocartography/astrodynes', $this->http->lastPath);
    }

    public function testCompareAstrodynes(): void
    {
        $this->client->compareAstrodynes(['subject' => $this->subject()]);

        self::assertSame('/api/v3/astrocartography/astrodynes/compare', $this->http->lastPath);
    }

    public function testRender(): void
    {
        $this->client->render(['subject' => $this->subject()]);

        self::assertSame('/api/v3/astrocartography/render', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Person',
            'birth_data' => [
                'year' => 1992,
                'month' => 2,
                'day' => 1,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
