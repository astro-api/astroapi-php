<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class HoraryClientTest extends IntegrationTestCase
{
    public function testGetGlossaryCategories(): void
    {
        $response = self::$client->horary->getGlossaryCategories();

        $this->assertSuccessResponse($response);
    }

    public function testGetGlossaryConsiderations(): void
    {
        $response = self::$client->horary->getGlossaryConsiderations();

        $this->assertSuccessResponse($response);
    }

    public function testGetChart(): void
    {
        $response = self::$client->horary->getChart([
            'question' => 'Should I take this job?',
            'question_time' => $this->dateTimeLocation(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
