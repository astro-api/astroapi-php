<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Utils;

use Procoders\AstrologyApi\Exceptions\AstrologyError;

/**
 * Runtime validation helpers mirroring the TypeScript SDK behaviour.
 */
final class Validators
{
    private const ISO_DATE_PATTERN = '/^\d{4}-\d{2}-\d{2}$/';
    private const ISO_MONTH_PATTERN = '/^\d{4}-(0[1-9]|1[0-2])$/';
    private const YEAR_MIN = 1900;
    private const YEAR_MAX = 2100;
    private const HOROSCOPE_FORMATS = ['paragraph', 'bullets', 'short', 'long'];
    private const SUN_SIGNS = [
        'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces',
        'Ari', 'Tau', 'Gem', 'Can', 'Vir', 'Lib', 'Sco', 'Sag', 'Cap', 'Aqu', 'Pis',
    ];
    private const CHINESE_LANGUAGES = ['en', 'fr', 'pt', 'it', 'zh', 'es', 'ru', 'tr', 'de', 'hi', 'uk'];
    private const CHINESE_GENDERS = ['male', 'female'];
    private const PROGRESSION_TYPES = ['secondary', 'primary', 'tertiary', 'minor'];
    private const DIRECTION_TYPES = ['solar_arc', 'symbolic', 'profection', 'naibod'];
    private const ACTIVE_POINT_TYPES = ['planet', 'lunar-node', 'angle', 'special-point', 'asteroid', 'fixed-star'];
    private const PRIMARY_ACTIVE_POINT_TYPES = ['planet', 'lunar-node', 'angle', 'special-point', 'asteroid'];
    private const HOUSE_SYSTEM_CODES = ['P', 'W', 'K', 'A', 'R', 'C', 'B', 'M', 'O', 'E', 'V', 'X', 'H', 'T', 'G'];
    private const KEYWORD_CATEGORIES = ['planets', 'lines', 'houses', 'aspects', 'themes'];
    private const LIFE_AREAS_LANGUAGES = ['en', 'de', 'fr', 'es', 'ru'];
    private const CITY_SORT_BY_VALUES = ['population', 'name'];
    private const SORT_ORDER_VALUES = ['asc', 'desc'];

    private function __construct()
    {
    }

    /**
     * @param array<string, mixed> $subject
     */
    public static function validateSubject(array $subject, string $context = 'subject'): void
    {
        if ($subject === [] || !array_key_exists('birth_data', $subject)) {
            throw new AstrologyError(sprintf('%s is required.', $context));
        }

        if (!is_array($subject['birth_data'])) {
            throw new AstrologyError(sprintf('%s.birth_data must be an object.', $context));
        }

        self::assertBirthData($subject['birth_data'], $context . '.birth_data');

        if (array_key_exists('name', $subject)) {
            $name = self::assertNonEmptyString($subject['name'], $context . '.name');
            if (!preg_match('/[A-Za-z]/', $name)) {
                throw new AstrologyError(sprintf('%s must contain at least one letter.', $context . '.name'));
            }
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateGlobalDataRequest(array $request, string $context): void
    {
        self::assertIntegerInRange($request['year'] ?? null, self::YEAR_MIN, self::YEAR_MAX, $context . '.year');
        self::assertIntegerInRange($request['month'] ?? null, 1, 12, $context . '.month');
        self::assertIntegerInRange($request['day'] ?? null, 1, 31, $context . '.day');
        self::assertIntegerInRange($request['hour'] ?? null, 0, 23, $context . '.hour');
        self::assertIntegerInRange($request['minute'] ?? null, 0, 59, $context . '.minute');
        self::assertIntegerInRange($request['second'] ?? null, 0, 59, $context . '.second');
    }

    /**
     * @param array<string, mixed> $value
     */
    public static function validateDateTimeLocation(array $value, string $context): void
    {
        self::assertIntegerInRange($value['year'] ?? null, self::YEAR_MIN, self::YEAR_MAX, $context . '.year');
        self::assertIntegerInRange($value['month'] ?? null, 1, 12, $context . '.month');
        self::assertIntegerInRange($value['day'] ?? null, 1, 31, $context . '.day');
        self::assertIntegerInRange($value['hour'] ?? null, 0, 23, $context . '.hour');
        self::assertIntegerInRange($value['minute'] ?? null, 0, 59, $context . '.minute');
        self::assertIntegerInRange($value['second'] ?? null, 0, 59, $context . '.second');
        self::assertOptionalFloatInRange($value['latitude'] ?? null, -90, 90, $context . '.latitude');
        self::assertOptionalFloatInRange($value['longitude'] ?? null, -180, 180, $context . '.longitude');
        self::assertOptionalString($value['timezone'] ?? null, $context . '.timezone');
    }

    /**
     * @param array<string, mixed>|null $value
     */
    public static function validateOptionalDateTimeLocation(?array $value, string $context): void
    {
        if ($value === null) {
            return;
        }

        self::validateDateTimeLocation($value, $context);
    }

    /**
     * @param array<string, mixed> $range
     */
    public static function validateDateRange(array $range, string $context): void
    {
        self::validateIsoDateString($range['start'] ?? null, $context . '.start');
        self::validateIsoDateString($range['end'] ?? null, $context . '.end');

        $start = $range['start'];
        $end = $range['end'];
        if (is_string($start) && is_string($end) && strcmp($start, $end) > 0) {
            throw new AstrologyError(sprintf('%s.end must not be before %s.start.', $context, $context));
        }
    }

    /**
     * @param array<string, mixed>|null $range
     */
    public static function validateOptionalDateRange(?array $range, string $context): void
    {
        if ($range === null) {
            return;
        }

        self::validateDateRange($range, $context);
    }

    public static function validateIsoDateString(?string $value, string $field): void
    {
        $date = self::assertNonEmptyString($value, $field);
        if (!preg_match(self::ISO_DATE_PATTERN, $date)) {
            throw new AstrologyError(sprintf('%s must be in YYYY-MM-DD format.', $field));
        }
    }

    public static function validateOptionalIsoDateString(?string $value, string $field): void
    {
        if ($value === null) {
            return;
        }

        self::validateIsoDateString($value, $field);
    }

    public static function validateProgressionTypeValue(?string $value, string $field): void
    {
        if ($value === null || !in_array($value, self::PROGRESSION_TYPES, true)) {
            throw new AstrologyError(sprintf('%s must be one of %s.', $field, implode(', ', self::PROGRESSION_TYPES)));
        }
    }

    public static function validateDirectionTypeValue(?string $value, string $field): void
    {
        if ($value === null || !in_array($value, self::DIRECTION_TYPES, true)) {
            throw new AstrologyError(sprintf('%s must be one of %s.', $field, implode(', ', self::DIRECTION_TYPES)));
        }
    }

    public static function validateOrbValue(mixed $value, string $field): void
    {
        self::assertPositiveNumber($value, $field);
    }

    public static function validateArcRate(mixed $value, string $field): void
    {
        if ($value === null) {
            return;
        }

        self::assertPositiveNumber($value, $field);
    }

    public static function validateReturnYear(mixed $value, string $field): void
    {
        self::assertIntegerInRange($value, self::YEAR_MIN, self::YEAR_MAX, $field);
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalizedHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalizedHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalizedHoroscopeRequest.subject');
        self::validateOptionalIsoDateString($request['date'] ?? null, 'PersonalizedHoroscopeRequest.date');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalTextHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalTextHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalTextHoroscopeRequest.subject');
        self::validateOptionalIsoDateString($request['date'] ?? null, 'PersonalTextHoroscopeRequest.date');
        self::assertOptionalEnum($request['format'] ?? null, self::HOROSCOPE_FORMATS, 'PersonalTextHoroscopeRequest.format');
        self::assertOptionalBoolean($request['use_emoji'] ?? null, 'PersonalTextHoroscopeRequest.use_emoji');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSunSignHoroscopeRequest(array $request): void
    {
        self::assertSunSign($request['sign'] ?? null, 'SunSignHoroscopeRequest.sign');
        self::validateIsoDateString($request['date'] ?? null, 'SunSignHoroscopeRequest.date');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSunSignWeeklyHoroscopeRequest(array $request): void
    {
        self::assertSunSign($request['sign'] ?? null, 'SunSignWeeklyHoroscopeRequest.sign');
        self::validateOptionalIsoDateString($request['start_date'] ?? null, 'SunSignWeeklyHoroscopeRequest.start_date');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSunSignMonthlyHoroscopeRequest(array $request): void
    {
        self::assertSunSign($request['sign'] ?? null, 'SunSignMonthlyHoroscopeRequest.sign');
        if (array_key_exists('month', $request)) {
            self::assertMonth($request['month'], 'SunSignMonthlyHoroscopeRequest.month');
        }
        if (array_key_exists('year', $request)) {
            self::assertIntegerInRange($request['year'], self::YEAR_MIN, self::YEAR_MAX, 'SunSignMonthlyHoroscopeRequest.year');
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSunSignYearlyHoroscopeRequest(array $request): void
    {
        self::assertSunSign($request['sign'] ?? null, 'SunSignYearlyHoroscopeRequest.sign');
        if (array_key_exists('year', $request)) {
            self::assertIntegerInRange($request['year'], self::YEAR_MIN, self::YEAR_MAX, 'SunSignYearlyHoroscopeRequest.year');
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateTextHoroscopeRequest(array $request): void
    {
        self::assertSunSign($request['sign'] ?? null, 'TextHoroscopeRequest.sign');
        self::validateOptionalIsoDateString($request['date'] ?? null, 'TextHoroscopeRequest.date');
        self::assertOptionalEnum($request['format'] ?? null, self::HOROSCOPE_FORMATS, 'TextHoroscopeRequest.format');
        self::assertOptionalBoolean($request['use_emoji'] ?? null, 'TextHoroscopeRequest.use_emoji');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateTextWeeklyHoroscopeRequest(array $request): void
    {
        self::validateTextHoroscopeRequest($request);
        self::validateOptionalIsoDateString($request['start_date'] ?? null, 'TextWeeklyHoroscopeRequest.start_date');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateTextMonthlyHoroscopeRequest(array $request): void
    {
        self::validateTextHoroscopeRequest($request);
        self::assertMonth($request['month'] ?? null, 'TextMonthlyHoroscopeRequest.month');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateChineseHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('ChineseHoroscopeRequest.subject is required.');
        }

        self::assertBirthData($request['subject']['birth_data'] ?? null, 'ChineseHoroscopeRequest.subject.birth_data');

        if (array_key_exists('gender', $request['subject'])) {
            self::assertOptionalEnum($request['subject']['gender'], self::CHINESE_GENDERS, 'ChineseHoroscopeRequest.subject.gender');
        }

        if (array_key_exists('year', $request)) {
            self::assertIntegerInRange($request['year'], self::YEAR_MIN, self::YEAR_MAX, 'ChineseHoroscopeRequest.year');
        }
        self::assertOptionalEnum($request['language'] ?? null, self::CHINESE_LANGUAGES, 'ChineseHoroscopeRequest.language');
    }

    public static function validateActivePointsQuery(?array $query, string $context = 'ActivePointsQuery'): void
    {
        if ($query === null || !array_key_exists('type', $query) || $query['type'] === null) {
            return;
        }

        if (!in_array($query['type'], self::ACTIVE_POINT_TYPES, true)) {
            throw new AstrologyError(sprintf('%s.type must be one of %s.', $context, implode(', ', self::ACTIVE_POINT_TYPES)));
        }
    }

    public static function validatePrimaryActivePointsQuery(?array $query, string $context = 'PrimaryActivePointsQuery'): void
    {
        if ($query === null || !array_key_exists('type', $query) || $query['type'] === null) {
            return;
        }

        if (!in_array($query['type'], self::PRIMARY_ACTIVE_POINT_TYPES, true)) {
            throw new AstrologyError(sprintf('%s.type must be one of %s.', $context, implode(', ', self::PRIMARY_ACTIVE_POINT_TYPES)));
        }
    }

    public static function validateCitySearchParams(array $params): void
    {
        if (isset($params['sort_by']) && !in_array($params['sort_by'], self::CITY_SORT_BY_VALUES, true)) {
            throw new AstrologyError(sprintf('CitySearchParams.sort_by must be one of %s.', implode(', ', self::CITY_SORT_BY_VALUES)));
        }

        if (isset($params['sort_order']) && !in_array($params['sort_order'], self::SORT_ORDER_VALUES, true)) {
            throw new AstrologyError(sprintf('CitySearchParams.sort_order must be one of %s.', implode(', ', self::SORT_ORDER_VALUES)));
        }

        if (isset($params['limit'])) {
            self::assertIntegerInRange($params['limit'], 1, 1000, 'CitySearchParams.limit');
        }

        if (isset($params['offset'])) {
            if (!is_int($params['offset']) || $params['offset'] < 0) {
                throw new AstrologyError('CitySearchParams.offset must be a non-negative integer.');
            }
        }
    }

    public static function validateHousesRequest(?array $request, string $context = 'HousesRequest'): void
    {
        if ($request === null || !array_key_exists('house_system', $request) || $request['house_system'] === null) {
            return;
        }

        if (!in_array($request['house_system'], self::HOUSE_SYSTEM_CODES, true)) {
            throw new AstrologyError(sprintf('%s.house_system must be one of %s.', $context, implode(', ', self::HOUSE_SYSTEM_CODES)));
        }
    }

    public static function validateKeywordsRequest(?array $request, string $context = 'KeywordsRequest'): void
    {
        if ($request === null || !array_key_exists('category', $request) || $request['category'] === null) {
            return;
        }

        if (!in_array($request['category'], self::KEYWORD_CATEGORIES, true)) {
            throw new AstrologyError(sprintf('%s.category must be one of %s.', $context, implode(', ', self::KEYWORD_CATEGORIES)));
        }
    }

    public static function validateLifeAreasRequest(?array $request, string $context = 'LifeAreasRequest'): void
    {
        if ($request === null || !array_key_exists('language', $request) || $request['language'] === null) {
            return;
        }

        if (!in_array($request['language'], self::LIFE_AREAS_LANGUAGES, true)) {
            throw new AstrologyError(sprintf('%s.language must be one of %s.', $context, implode(', ', self::LIFE_AREAS_LANGUAGES)));
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateNatalReportRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'NatalReportRequest.subject');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSynastryReportRequest(array $request): void
    {
        self::validateSubject($request['subject1'] ?? [], 'SynastryReportRequest.subject1');
        self::validateSubject($request['subject2'] ?? [], 'SynastryReportRequest.subject2');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateCompositeReportRequest(array $request): void
    {
        self::validateSubject($request['subject1'] ?? [], 'CompositeReportRequest.subject1');
        self::validateSubject($request['subject2'] ?? [], 'CompositeReportRequest.subject2');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateCompatibilityRequest(array $request): void
    {
        if (!isset($request['subjects']) || !is_array($request['subjects']) || count($request['subjects']) < 2) {
            throw new AstrologyError('CompatibilityRequest.subjects must include at least two entries.');
        }

        foreach ($request['subjects'] as $index => $subject) {
            if (!is_array($subject)) {
                throw new AstrologyError(sprintf('CompatibilityRequest.subjects[%d] must be an object.', $index));
            }
            self::validateSubject($subject, sprintf('CompatibilityRequest.subjects[%d]', $index));
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateRelationshipAnalysisRequest(array $request): void
    {
        if (!isset($request['subjects']) || !is_array($request['subjects']) || count($request['subjects']) < 2) {
            throw new AstrologyError('RelationshipAnalysisRequest.subjects must include at least two entries.');
        }

        foreach ($request['subjects'] as $index => $subject) {
            if (!is_array($subject)) {
                throw new AstrologyError(sprintf('RelationshipAnalysisRequest.subjects[%d] must be an object.', $index));
            }
            self::validateSubject($subject, sprintf('RelationshipAnalysisRequest.subjects[%d]', $index));
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSynastryChartRequest(array $request, string $context = 'SynastryChartRequest'): void
    {
        self::validateSubject($request['subject1'] ?? [], $context . '.subject1');
        self::validateSubject($request['subject2'] ?? [], $context . '.subject2');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateNatalTransitRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'NatalTransitRequest.subject');
        self::validateOptionalDateRange($request['date_range'] ?? null, 'NatalTransitRequest.date_range');
        self::validateOrbValue($request['orb'] ?? null, 'NatalTransitRequest.orb');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateProgressionReportRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'ProgressionReportRequest.subject');
        self::validateIsoDateString($request['target_date'] ?? null, 'ProgressionReportRequest.target_date');
        self::validateProgressionTypeValue($request['progression_type'] ?? null, 'ProgressionReportRequest.progression_type');
        self::validateOptionalDateTimeLocation($request['location'] ?? null, 'ProgressionReportRequest.location');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateDirectionReportRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'DirectionReportRequest.subject');
        self::validateIsoDateString($request['target_date'] ?? null, 'DirectionReportRequest.target_date');
        self::validateDirectionTypeValue($request['direction_type'] ?? null, 'DirectionReportRequest.direction_type');
        self::validateArcRate($request['arc_rate'] ?? null, 'DirectionReportRequest.arc_rate');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateLunarReturnReportRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'LunarReturnReportRequest.subject');
        self::validateIsoDateString($request['return_date'] ?? null, 'LunarReturnReportRequest.return_date');
        self::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'LunarReturnReportRequest.return_location');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSolarReturnReportRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'SolarReturnReportRequest.subject');
        self::validateReturnYear($request['return_year'] ?? null, 'SolarReturnReportRequest.return_year');
        self::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'SolarReturnReportRequest.return_location');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateLunarReturnTransitRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'LunarReturnTransitRequest.subject');
        self::validateIsoDateString($request['return_date'] ?? null, 'LunarReturnTransitRequest.return_date');
        self::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'LunarReturnTransitRequest.return_location');
        self::validateDateRange($request['date_range'] ?? [], 'LunarReturnTransitRequest.date_range');
        self::validateOrbValue($request['orb'] ?? null, 'LunarReturnTransitRequest.orb');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSolarReturnTransitRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'SolarReturnTransitRequest.subject');
        self::validateReturnYear($request['return_year'] ?? null, 'SolarReturnTransitRequest.return_year');
        self::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'SolarReturnTransitRequest.return_location');
        self::validateDateRange($request['date_range'] ?? [], 'SolarReturnTransitRequest.date_range');
        self::validateOrbValue($request['orb'] ?? null, 'SolarReturnTransitRequest.orb');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateLunarAnalysisRequest(array $request): void
    {
        self::validateDateTimeLocation($request['datetime_location'] ?? [], 'LunarAnalysisRequest.datetime_location');
        self::assertOptionalString($request['tradition'] ?? null, 'LunarAnalysisRequest.tradition');
        self::assertOptionalString($request['language'] ?? null, 'LunarAnalysisRequest.language');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateVenusReturnReportRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'VenusReturnReportRequest.subject');
        self::validateReturnYear($request['return_year'] ?? null, 'VenusReturnReportRequest.return_year');
        self::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'VenusReturnReportRequest.return_location');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateVenusReturnTransitRequest(array $request): void
    {
        self::validateSubject($request['subject'] ?? [], 'VenusReturnTransitRequest.subject');
        self::validateReturnYear($request['return_year'] ?? null, 'VenusReturnTransitRequest.return_year');
        self::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'VenusReturnTransitRequest.return_location');
        self::validateDateRange($request['date_range'] ?? [], 'VenusReturnTransitRequest.date_range');
        self::validateOrbValue($request['orb'] ?? null, 'VenusReturnTransitRequest.orb');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalWeeklyHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalWeeklyHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalWeeklyHoroscopeRequest.subject');
        self::validateOptionalIsoDateString($request['start_date'] ?? null, 'PersonalWeeklyHoroscopeRequest.start_date');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalWeeklyTextHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalWeeklyTextHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalWeeklyTextHoroscopeRequest.subject');
        self::validateOptionalIsoDateString($request['start_date'] ?? null, 'PersonalWeeklyTextHoroscopeRequest.start_date');
        self::assertOptionalEnum($request['format'] ?? null, self::HOROSCOPE_FORMATS, 'PersonalWeeklyTextHoroscopeRequest.format');
        self::assertOptionalBoolean($request['use_emoji'] ?? null, 'PersonalWeeklyTextHoroscopeRequest.use_emoji');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalMonthlyHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalMonthlyHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalMonthlyHoroscopeRequest.subject');
        if (array_key_exists('month', $request)) {
            self::assertMonth($request['month'], 'PersonalMonthlyHoroscopeRequest.month');
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalMonthlyTextHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalMonthlyTextHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalMonthlyTextHoroscopeRequest.subject');
        if (array_key_exists('month', $request)) {
            self::assertMonth($request['month'], 'PersonalMonthlyTextHoroscopeRequest.month');
        }
        self::assertOptionalEnum($request['format'] ?? null, self::HOROSCOPE_FORMATS, 'PersonalMonthlyTextHoroscopeRequest.format');
        self::assertOptionalBoolean($request['use_emoji'] ?? null, 'PersonalMonthlyTextHoroscopeRequest.use_emoji');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalYearlyHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalYearlyHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalYearlyHoroscopeRequest.subject');
        if (array_key_exists('year', $request)) {
            self::assertIntegerInRange($request['year'], self::YEAR_MIN, self::YEAR_MAX, 'PersonalYearlyHoroscopeRequest.year');
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validatePersonalYearlyTextHoroscopeRequest(array $request): void
    {
        if (!isset($request['subject']) || !is_array($request['subject'])) {
            throw new AstrologyError('PersonalYearlyTextHoroscopeRequest.subject is required.');
        }

        self::validateSubject($request['subject'], 'PersonalYearlyTextHoroscopeRequest.subject');
        if (array_key_exists('year', $request)) {
            self::assertIntegerInRange($request['year'], self::YEAR_MIN, self::YEAR_MAX, 'PersonalYearlyTextHoroscopeRequest.year');
        }
        self::assertOptionalEnum($request['format'] ?? null, self::HOROSCOPE_FORMATS, 'PersonalYearlyTextHoroscopeRequest.format');
        self::assertOptionalBoolean($request['use_emoji'] ?? null, 'PersonalYearlyTextHoroscopeRequest.use_emoji');
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function validateSignYearlyTextHoroscopeRequest(array $request): void
    {
        self::assertSunSign($request['sign'] ?? null, 'SignYearlyTextHoroscopeRequest.sign');
        if (array_key_exists('year', $request)) {
            self::assertIntegerInRange($request['year'], self::YEAR_MIN, self::YEAR_MAX, 'SignYearlyTextHoroscopeRequest.year');
        }
        self::assertOptionalEnum($request['format'] ?? null, self::HOROSCOPE_FORMATS, 'SignYearlyTextHoroscopeRequest.format');
        self::assertOptionalBoolean($request['use_emoji'] ?? null, 'SignYearlyTextHoroscopeRequest.use_emoji');
    }

    /**
     * @param array<string, mixed>|null $birthData
     */
    private static function assertBirthData(null|array $birthData, string $field): void
    {
        if ($birthData === null) {
            throw new AstrologyError(sprintf('%s is required.', $field));
        }

        self::assertIntegerInRange($birthData['year'] ?? null, self::YEAR_MIN, self::YEAR_MAX, $field . '.year');
        self::assertIntegerInRange($birthData['month'] ?? null, 1, 12, $field . '.month');
        self::assertIntegerInRange($birthData['day'] ?? null, 1, 31, $field . '.day');

        if (isset($birthData['year'], $birthData['month'], $birthData['day'])
            && is_int($birthData['year']) && is_int($birthData['month']) && is_int($birthData['day'])
            && !checkdate($birthData['month'], $birthData['day'], $birthData['year'])
        ) {
            throw new AstrologyError(sprintf('%s contains an invalid calendar date.', $field));
        }

        self::assertIntegerInRange($birthData['hour'] ?? null, 0, 23, $field . '.hour');
        self::assertIntegerInRange($birthData['minute'] ?? null, 0, 59, $field . '.minute');
        self::assertIntegerInRange($birthData['second'] ?? null, 0, 59, $field . '.second');
        self::assertOptionalFloatInRange($birthData['latitude'] ?? null, -90, 90, $field . '.latitude');
        self::assertOptionalFloatInRange($birthData['longitude'] ?? null, -180, 180, $field . '.longitude');
        self::assertOptionalString($birthData['city'] ?? null, $field . '.city');
        if (array_key_exists('country_code', $birthData)) {
            $code = self::assertNonEmptyString($birthData['country_code'], $field . '.country_code');
            if (strlen($code) !== 2) {
                throw new AstrologyError(sprintf('%s must be a two-letter ISO code.', $field . '.country_code'));
            }
        }
    }

    private static function assertSunSign(mixed $value, string $field): void
    {
        $sign = self::assertNonEmptyString($value, $field);
        if (!in_array($sign, self::SUN_SIGNS, true)) {
            throw new AstrologyError(sprintf('%s must be a valid sun sign.', $field));
        }
    }

    private static function assertMonth(mixed $value, string $field): void
    {
        $month = self::assertNonEmptyString($value, $field);
        if (!preg_match(self::ISO_MONTH_PATTERN, $month)) {
            throw new AstrologyError(sprintf('%s must be in YYYY-MM format.', $field));
        }
    }

    private static function assertOptionalEnum(mixed $value, array $allowed, string $field): void
    {
        if ($value === null) {
            return;
        }

        if (!is_string($value)) {
            throw new AstrologyError(sprintf('%s must be a string.', $field));
        }

        if (!in_array($value, $allowed, true)) {
            throw new AstrologyError(sprintf('%s must be one of %s.', $field, implode(', ', $allowed)));
        }
    }

    private static function assertOptionalBoolean(mixed $value, string $field): void
    {
        if ($value === null) {
            return;
        }

        if (!is_bool($value)) {
            throw new AstrologyError(sprintf('%s must be a boolean.', $field));
        }
    }

    private static function assertOptionalString(mixed $value, string $field): void
    {
        if ($value === null) {
            return;
        }

        self::assertNonEmptyString($value, $field);
    }

    private static function assertPositiveNumber(mixed $value, string $field): void
    {
        if (!is_int($value) && !is_float($value)) {
            throw new AstrologyError(sprintf('%s must be a number.', $field));
        }

        if ((float) $value <= 0.0) {
            throw new AstrologyError(sprintf('%s must be greater than zero.', $field));
        }
    }

    private static function assertOptionalFloatInRange(mixed $value, float $min, float $max, string $field): void
    {
        if ($value === null) {
            return;
        }

        if (!is_int($value) && !is_float($value)) {
            throw new AstrologyError(sprintf('%s must be a number.', $field));
        }

        $float = (float) $value;
        if ($float < $min || $float > $max) {
            throw new AstrologyError(sprintf('%s must be between %s and %s.', $field, (string) $min, (string) $max));
        }
    }

    private static function assertIntegerInRange(mixed $value, int $min, int $max, string $field): void
    {
        if (!is_int($value)) {
            throw new AstrologyError(sprintf('%s must be an integer.', $field));
        }

        if ($value < $min || $value > $max) {
            throw new AstrologyError(sprintf('%s must be between %d and %d.', $field, $min, $max));
        }
    }

    private static function assertNonEmptyString(mixed $value, string $field): string
    {
        if (!is_string($value)) {
            throw new AstrologyError(sprintf('%s must be a string.', $field));
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new AstrologyError(sprintf('%s must be a non-empty string.', $field));
        }

        return $trimmed;
    }
}
