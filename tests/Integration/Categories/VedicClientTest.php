<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class VedicClientTest extends IntegrationTestCase
{
    public function testGetChart(): void
    {
        $response = self::$client->vedic->getChart([
            'subject' => $this->subject(),
        ]);

        self::assertNotNull($response, 'API response should not be null');
    }

    public function testGetBirthDetails(): void
    {
        $response = self::$client->vedic->getBirthDetails([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetManglikDosha(): void
    {
        $response = self::$client->vedic->getManglikDosha([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
