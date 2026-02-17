<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class AnalysisClientTest extends IntegrationTestCase
{
    public function testGetNatalReport(): void
    {
        $response = self::$client->analysis->getNatalReport([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetCompatibilityScore(): void
    {
        $response = self::$client->analysis->getCompatibilityScore([
            'subject1' => $this->subject(),
            'subject2' => $this->secondSubject(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
