<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Utils;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Exceptions\AstrologyError;
use Procoders\AstrologyApi\Utils\Validators;

final class ValidatorsTest extends TestCase
{
    private function validSubject(): array
    {
        return [
            'name' => 'Sample',
            'birth_data' => [
                'year' => 1990,
                'month' => 5,
                'day' => 20,
                'hour' => 14,
                'minute' => 30,
                'second' => 0,
            ],
        ];
    }

    public function testValidateSubjectSuccess(): void
    {
        Validators::validateSubject($this->validSubject(), 'Test.subject');
        $this->addToAssertionCount(1);
    }

    public function testValidateSubjectRequiresBirthData(): void
    {
        $this->expectException(AstrologyError::class);
        Validators::validateSubject(['name' => 'Missing'], 'Test.subject');
    }

    public function testPersonalizedHoroscopeAllowsOptionalDate(): void
    {
        Validators::validatePersonalizedHoroscopeRequest([
            'subject' => $this->validSubject(),
        ]);
        $this->addToAssertionCount(1);
    }

    public function testSunSignMonthlyAcceptsOptionalMonthAndYear(): void
    {
        Validators::validateSunSignMonthlyHoroscopeRequest(['sign' => 'Aries']);
        $this->addToAssertionCount(1);
    }

    public function testActivePointsQueryRejectsInvalidType(): void
    {
        $this->expectException(AstrologyError::class);
        Validators::validateActivePointsQuery(['type' => 'invalid']);
    }

    public function testCitySearchParamsValidatesSortOptions(): void
    {
        Validators::validateCitySearchParams([
            'sort_by' => 'population',
            'sort_order' => 'asc',
            'limit' => 10,
            'offset' => 0,
        ]);
        $this->addToAssertionCount(1);
    }

    public function testRelationshipAnalysisRequiresTwoSubjects(): void
    {
        $this->expectException(AstrologyError::class);
        Validators::validateRelationshipAnalysisRequest(['subjects' => [$this->validSubject()]]);
    }
}
