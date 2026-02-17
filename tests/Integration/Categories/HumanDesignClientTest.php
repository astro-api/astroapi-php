<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class HumanDesignClientTest extends IntegrationTestCase
{
    public function testGetBodygraph(): void
    {
        $response = self::$client->humanDesign->getBodygraph([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetGlossaryTypes(): void
    {
        $response = self::$client->humanDesign->getGlossaryTypes();

        $this->assertSuccessResponse($response);
    }

    public function testGetGlossaryGates(): void
    {
        $response = self::$client->humanDesign->getGlossaryGates();

        $this->assertSuccessResponse($response);
    }
}
