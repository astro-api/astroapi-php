<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\HumanDesignClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class HumanDesignClientTest extends TestCase
{
    private HumanDesignClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new HumanDesignClient($this->http);
    }

    public function testGetBodygraph(): void
    {
        $this->client->getBodygraph(['subject' => $this->subject()]);

        self::assertSame('/api/v3/human-design/bodygraph', $this->http->lastPath);
    }

    public function testGetCompatibility(): void
    {
        $this->client->getCompatibility(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/human-design/compatibility', $this->http->lastPath);
    }

    public function testGetDesignDate(): void
    {
        $this->client->getDesignDate(['subject' => $this->subject()]);

        self::assertSame('/api/v3/human-design/design-date', $this->http->lastPath);
    }

    public function testGetTransits(): void
    {
        $this->client->getTransits(['date' => '2024-01-01']);

        self::assertSame('/api/v3/human-design/transits', $this->http->lastPath);
    }

    public function testGetType(): void
    {
        $this->client->getType(['subject' => $this->subject()]);

        self::assertSame('/api/v3/human-design/type', $this->http->lastPath);
    }

    public function testGetGlossaryChannels(): void
    {
        $this->client->getGlossaryChannels();

        self::assertSame('/api/v3/human-design/glossary/channels', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testGetGlossaryGates(): void
    {
        $this->client->getGlossaryGates();

        self::assertSame('/api/v3/human-design/glossary/gates', $this->http->lastPath);
    }

    public function testGetGlossaryTypes(): void
    {
        $this->client->getGlossaryTypes();

        self::assertSame('/api/v3/human-design/glossary/types', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'HD User',
            'birth_data' => [
                'year' => 1985,
                'month' => 3,
                'day' => 22,
                'hour' => 14,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
