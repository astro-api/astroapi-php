<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class TarotClientTest extends IntegrationTestCase
{
    public function testGetCardsGlossary(): void
    {
        $response = self::$client->tarot->getCardsGlossary();

        $this->assertSuccessResponse($response);
    }

    public function testGetSpreadsGlossary(): void
    {
        $response = self::$client->tarot->getSpreadsGlossary();

        $this->assertSuccessResponse($response);
    }

    public function testGetDailyCard(): void
    {
        $response = self::$client->tarot->getDailyCard([
            'sign' => 'Aries',
            'user_id' => 'integration-test-user',
        ]);

        $this->assertSuccessResponse($response);
    }
}
