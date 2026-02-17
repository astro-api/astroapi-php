<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class FengshuiClientTest extends IntegrationTestCase
{
    public function testGetAfflictions(): void
    {
        $response = self::$client->fengshui->getAfflictions(2024);

        $this->assertSuccessResponse($response);
    }

    public function testGetGlossaryStars(): void
    {
        $response = self::$client->fengshui->getGlossaryStars();

        $this->assertSuccessResponse($response);
    }
}
