<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class EnhancedClientTest extends IntegrationTestCase
{
    public function testGetPersonalAnalysis(): void
    {
        $response = self::$client->enhanced->getPersonalAnalysis([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
