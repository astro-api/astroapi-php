<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class ChartsClientTest extends IntegrationTestCase
{
    public function testGetNatalChart(): void
    {
        $response = self::$client->charts->getNatalChart([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetSynastryChart(): void
    {
        $response = self::$client->charts->getSynastryChart([
            'subject1' => $this->subject(),
            'subject2' => $this->secondSubject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetTransitChart(): void
    {
        $response = self::$client->charts->getTransitChart([
            'natal_subject' => $this->subject(),
            'transit_datetime' => $this->dateTimeLocation(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetSolarReturnChart(): void
    {
        $response = self::$client->charts->getSolarReturnChart([
            'subject' => $this->subject(),
            'return_year' => 2024,
        ]);

        $this->assertSuccessResponse($response);
    }
}
