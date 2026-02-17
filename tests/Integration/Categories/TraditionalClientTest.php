<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class TraditionalClientTest extends IntegrationTestCase
{
    public function testGetAnalysis(): void
    {
        $response = self::$client->traditional->getAnalysis([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetCapabilities(): void
    {
        $response = self::$client->traditional->getCapabilities();

        $this->assertSuccessResponse($response);
    }

    public function testGetTraditionalPointsGlossary(): void
    {
        $response = self::$client->traditional->getTraditionalPointsGlossary();

        $this->assertSuccessResponse($response);
    }
}
