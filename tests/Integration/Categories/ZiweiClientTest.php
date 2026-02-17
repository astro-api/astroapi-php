<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class ZiweiClientTest extends IntegrationTestCase
{
    public function testGetChart(): void
    {
        $subject = $this->subject();

        $response = self::$client->ziwei->getChart([
            'subject' => $subject,
            'birth_data' => $subject['birth_data'],
            'gender' => 'male',
        ]);

        $this->assertSuccessResponse($response);
    }
}
