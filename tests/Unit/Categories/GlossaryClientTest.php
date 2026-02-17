<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\GlossaryClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class GlossaryClientTest extends TestCase
{
    private GlossaryClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new GlossaryClient($this->http);
    }

    public function testActivePointsQuery(): void
    {
        $this->client->getActivePoints(['type' => 'planet']);

        self::assertSame('/api/v3/glossary/active-points', $this->http->lastPath);
        self::assertSame(['type' => 'planet'], $this->http->lastQuery);
    }

    public function testCitiesPassesParams(): void
    {
        $params = ['limit' => 5, 'sort_by' => 'population'];
        $this->client->getCities($params);

        self::assertSame('/api/v3/glossary/cities', $this->http->lastPath);
        self::assertSame($params, $this->http->lastQuery);
    }

    public function testGetLanguages(): void
    {
        $this->client->getLanguages();

        self::assertSame('/api/v3/glossary/languages', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testGetHoraryCategories(): void
    {
        $this->client->getHoraryCategories();

        self::assertSame('/api/v3/glossary/horary-categories', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }
}
