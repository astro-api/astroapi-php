<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\InsightsClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class InsightsClientTest extends TestCase
{
    private InsightsClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new InsightsClient($this->http);
    }

    public function testDiscover(): void
    {
        $this->client->discover();

        self::assertSame('/api/v3/insights', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testRelationshipCompatibility(): void
    {
        $this->client->relationship->getCompatibility(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/insights/relationship/compatibility', $this->http->lastPath);
    }

    public function testPetPersonality(): void
    {
        $this->client->pet->getPersonality(['subject' => $this->subject()]);

        self::assertSame('/api/v3/insights/pet/personality', $this->http->lastPath);
    }

    public function testWellnessBodyMapping(): void
    {
        $this->client->wellness->getBodyMapping(['subject' => $this->subject()]);

        self::assertSame('/api/v3/insights/wellness/body-mapping', $this->http->lastPath);
    }

    public function testFinancialMarketTiming(): void
    {
        $this->client->financial->getMarketTiming(['market' => 'stocks']);

        self::assertSame('/api/v3/insights/financial/market-timing', $this->http->lastPath);
    }

    public function testBusinessTeamDynamics(): void
    {
        $this->client->business->getTeamDynamics(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/insights/business/team-dynamics', $this->http->lastPath);
    }

    public function testBusinessDepartmentCompatibility(): void
    {
        $this->client->business->getDepartmentCompatibility(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/insights/business/department-compatibility', $this->http->lastPath);
    }

    public function testBusinessHiringCompatibility(): void
    {
        $this->client->business->getHiringCompatibility(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/insights/business/hiring-compatibility', $this->http->lastPath);
    }

    public function testBusinessLeadershipStyle(): void
    {
        $this->client->business->getLeadershipStyle(['subject' => $this->subject()]);

        self::assertSame('/api/v3/insights/business/leadership-style', $this->http->lastPath);
    }

    public function testBusinessSuccessionPlanning(): void
    {
        $this->client->business->getSuccessionPlanning(['subjects' => [$this->subject(), $this->subject()]]);

        self::assertSame('/api/v3/insights/business/succession-planning', $this->http->lastPath);
    }

    public function testRelationshipDiscover(): void
    {
        $this->client->relationship->discover();

        self::assertSame('/api/v3/insights/relationship', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    private function subject(): array
    {
        return [
            'name' => 'Insight User',
            'birth_data' => [
                'year' => 1999,
                'month' => 4,
                'day' => 5,
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
