<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\RenderClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class RenderClientTest extends TestCase
{
    private RenderClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new RenderClient($this->http);
    }

    public function testGetNatalChart(): void
    {
        $this->client->getNatalChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/render/natal', $this->http->lastPath);
    }

    public function testGetSynastryChart(): void
    {
        $this->client->getSynastryChart([
            'subject1' => $this->subject(),
            'subject2' => $this->subject(),
        ]);

        self::assertSame('/api/v3/render/synastry', $this->http->lastPath);
    }

    public function testGetCompositeChart(): void
    {
        $this->client->getCompositeChart([
            'subject1' => $this->subject(),
            'subject2' => $this->subject(),
        ]);

        self::assertSame('/api/v3/render/composite', $this->http->lastPath);
    }

    public function testGetTransitChart(): void
    {
        $this->client->getTransitChart(['natal_subject' => $this->subject()]);

        self::assertSame('/api/v3/render/transit', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Render User',
            'birth_data' => [
                'year' => 1987,
                'month' => 12,
                'day' => 25,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
