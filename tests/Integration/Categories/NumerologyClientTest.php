<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class NumerologyClientTest extends IntegrationTestCase
{
    public function testGetCoreNumbers(): void
    {
        $response = self::$client->numerology->getCoreNumbers([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
