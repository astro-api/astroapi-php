<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class EclipsesClientTest extends IntegrationTestCase
{
    public function testGetUpcoming(): void
    {
        $response = self::$client->eclipses->getUpcoming();

        $this->assertSuccessResponse($response);
    }

    public function testCheckNatalImpact(): void
    {
        $response = self::$client->eclipses->checkNatalImpact([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
