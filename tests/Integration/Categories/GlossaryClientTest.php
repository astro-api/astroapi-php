<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class GlossaryClientTest extends IntegrationTestCase
{
    public function testGetCountries(): void
    {
        $response = self::$client->glossary->getCountries();

        $this->assertSuccessResponse($response);
    }

    public function testGetElements(): void
    {
        $response = self::$client->glossary->getElements();

        $this->assertSuccessResponse($response);
    }

    public function testGetLanguages(): void
    {
        $response = self::$client->glossary->getLanguages();

        $this->assertSuccessResponse($response);
    }

    public function testGetHouseSystems(): void
    {
        $response = self::$client->glossary->getHouseSystems();

        $this->assertSuccessResponse($response);
    }

    public function testGetHoraryCategories(): void
    {
        $response = self::$client->glossary->getHoraryCategories();

        $this->assertSuccessResponse($response);
    }
}
