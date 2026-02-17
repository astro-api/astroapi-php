<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class AstrocartographyClientTest extends IntegrationTestCase
{
    public function testGetLines(): void
    {
        $response = self::$client->astrocartography->getLines([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetLineMeanings(): void
    {
        $response = self::$client->astrocartography->getLineMeanings();

        $this->assertSuccessResponse($response);
    }

    public function testGetSupportedFeatures(): void
    {
        $response = self::$client->astrocartography->getSupportedFeatures();

        $this->assertSuccessResponse($response);
    }
}
