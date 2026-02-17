<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class FixedStarsClientTest extends IntegrationTestCase
{
    public function testGetPositions(): void
    {
        $response = self::$client->fixedStars->getPositions([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetPresets(): void
    {
        $response = self::$client->fixedStars->getPresets();

        $this->assertSuccessResponse($response);
    }
}
