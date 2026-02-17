<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class PdfClientTest extends IntegrationTestCase
{
    public function testGetHoroscopeData(): void
    {
        $response = self::$client->pdf->getHoroscopeData('Aries', '2024-06-15');

        $this->assertSuccessResponse($response);
    }

    public function testGetNatalReport(): void
    {
        $response = self::$client->pdf->getNatalReport([
            'subject' => $this->subject(),
        ], ['timeout' => 60]);

        self::assertNotNull($response, 'API response should not be null');
    }
}
