<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class PalmistryClientTest extends IntegrationTestCase
{
    public function testGetReading(): void
    {
        $response = self::$client->palmistry->getReading([
            'image_base64' => 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
        ]);

        self::assertNotNull($response, 'API response should not be null');
    }
}
