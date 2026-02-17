<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class KabbalahClientTest extends IntegrationTestCase
{
    public function testGetBirthAngels(): void
    {
        $subject = $this->subject();

        $response = self::$client->kabbalah->getBirthAngels([
            'subject' => $subject,
            'birth_data' => $subject['birth_data'],
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetGlossarySephiroth(): void
    {
        $response = self::$client->kabbalah->getGlossarySephiroth();

        $this->assertSuccessResponse($response);
    }

    public function testGetGlossaryAngels72(): void
    {
        $response = self::$client->kabbalah->getGlossaryAngels72();

        $this->assertSuccessResponse($response);
    }
}
