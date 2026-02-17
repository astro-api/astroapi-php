<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class RenderClientTest extends IntegrationTestCase
{
    public function testGetNatalChart(): void
    {
        $response = self::$client->render->getNatalChart([
            'subject' => $this->subject(),
        ]);

        self::assertNotNull($response, 'API response should not be null');
    }
}
