<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class HoroscopeClientTest extends IntegrationTestCase
{
    public function testGetSignDailyHoroscope(): void
    {
        $response = self::$client->horoscope->getSignDailyHoroscope([
            'sign' => 'Aries',
            'date' => '2024-06-15',
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetPersonalDailyHoroscope(): void
    {
        $response = self::$client->horoscope->getPersonalDailyHoroscope([
            'subject' => $this->subject(),
            'date' => '2024-06-15',
        ]);

        $this->assertSuccessResponse($response);
    }

    public function testGetSignWeeklyHoroscope(): void
    {
        $response = self::$client->horoscope->getSignWeeklyHoroscope([
            'sign' => 'Taurus',
            'start_date' => '2024-06-10',
        ]);

        $this->assertSuccessResponse($response);
    }
}
