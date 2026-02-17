<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class ChineseClientTest extends IntegrationTestCase
{
    public function testCalculateBaZi(): void
    {
        $response = self::$client->chinese->calculateBaZi([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testAnalyzeYearElements(): void
    {
        $response = self::$client->chinese->analyzeYearElements(2024);

        $this->assertSuccessResponse($response);
    }

    public function testGetZodiacAnimal(): void
    {
        $response = self::$client->chinese->getZodiacAnimal('dragon');

        $this->assertSuccessResponse($response);
    }
}
