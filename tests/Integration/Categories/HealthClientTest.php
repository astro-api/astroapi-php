<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class HealthClientTest extends IntegrationTestCase
{
    public function testCheck(): void
    {
        $response = self::$client->health->check();

        $this->assertSuccessResponse($response);
    }

    public function testDebugTimezone(): void
    {
        $response = self::$client->health->debugTimezone();

        $this->assertSuccessResponse($response);
    }
}
