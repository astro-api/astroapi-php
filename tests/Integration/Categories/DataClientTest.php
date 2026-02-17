<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class DataClientTest extends IntegrationTestCase
{
    public function testGetPositions(): void
    {
        $response = self::$client->data->getPositions([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetAspects(): void
    {
        $response = self::$client->data->getAspects([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetCurrentMoment(): void
    {
        $response = self::$client->data->getCurrentMoment();

        $this->assertSuccessResponse($response);
    }
}
