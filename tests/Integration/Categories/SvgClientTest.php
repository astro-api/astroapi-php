<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class SvgClientTest extends IntegrationTestCase
{
    public function testGetNatalChartSvg(): void
    {
        $response = self::$client->svg->getNatalChartSvg([
            'subject' => $this->subject(),
        ]);

        self::assertNotNull($response, 'API response should not be null');
    }
}
