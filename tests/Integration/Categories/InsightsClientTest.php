<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class InsightsClientTest extends IntegrationTestCase
{
    public function testDiscover(): void
    {
        $response = self::$client->insights->discover();

        $this->assertSuccessResponse($response);
    }

    public function testRelationshipCompatibility(): void
    {
        $response = self::$client->insights->relationship->getCompatibility([
            'subjects' => [
                $this->subject(),
                $this->secondSubject(),
            ],
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testRelationshipDiscover(): void
    {
        $response = self::$client->insights->relationship->discover();

        $this->assertSuccessResponse($response);
    }
}
