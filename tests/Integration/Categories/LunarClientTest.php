<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class LunarClientTest extends IntegrationTestCase
{
    public function testGetPhases(): void
    {
        $response = self::$client->lunar->getPhases([
            'datetime_location' => $this->dateTimeLocation(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetCalendar(): void
    {
        $response = self::$client->lunar->getCalendar(2024);

        $this->assertSuccessResponse($response);
    }
}
