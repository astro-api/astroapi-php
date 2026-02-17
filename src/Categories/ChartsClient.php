<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Charts category client providing access to chart generation endpoints.
 */
final class ChartsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/charts';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getNatalChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'NatalChartRequest.subject');

        return $this->http->post($this->buildUrl('natal'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getCompositeChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject1'] ?? [], 'CompositeChartRequest.subject1');
        Validators::validateSubject($request['subject2'] ?? [], 'CompositeChartRequest.subject2');

        return $this->http->post($this->buildUrl('composite'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSynastryChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject1'] ?? [], 'SynastryChartRequest.subject1');
        Validators::validateSubject($request['subject2'] ?? [], 'SynastryChartRequest.subject2');

        return $this->http->post($this->buildUrl('synastry'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getTransitChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['natal_subject'] ?? [], 'TransitChartRequest.natal_subject');
        Validators::validateDateTimeLocation($request['transit_datetime'] ?? [], 'TransitChartRequest.transit_datetime');

        return $this->http->post($this->buildUrl('transit'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSolarReturnChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'SolarReturnRequest.subject');
        Validators::validateReturnYear($request['return_year'] ?? null, 'SolarReturnRequest.return_year');
        Validators::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'SolarReturnRequest.return_location');

        return $this->http->post($this->buildUrl('solar-return'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getLunarReturnChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'LunarReturnRequest.subject');
        Validators::validateIsoDateString($request['return_date'] ?? null, 'LunarReturnRequest.return_date');
        Validators::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'LunarReturnRequest.return_location');

        return $this->http->post($this->buildUrl('lunar-return'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSolarReturnTransits(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'SolarReturnTransitRequest.subject');
        Validators::validateReturnYear($request['return_year'] ?? null, 'SolarReturnTransitRequest.return_year');
        Validators::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'SolarReturnTransitRequest.return_location');
        Validators::validateDateRange($request['date_range'] ?? [], 'SolarReturnTransitRequest.date_range');
        Validators::validateOrbValue($request['orb'] ?? null, 'SolarReturnTransitRequest.orb');

        return $this->http->post($this->buildUrl('solar-return-transits'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getLunarReturnTransits(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'LunarReturnTransitRequest.subject');
        Validators::validateIsoDateString($request['return_date'] ?? null, 'LunarReturnTransitRequest.return_date');
        Validators::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'LunarReturnTransitRequest.return_location');
        Validators::validateDateRange($request['date_range'] ?? [], 'LunarReturnTransitRequest.date_range');
        Validators::validateOrbValue($request['orb'] ?? null, 'LunarReturnTransitRequest.orb');

        return $this->http->post($this->buildUrl('lunar-return-transits'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getProgressions(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ProgressionRequest.subject');
        Validators::validateIsoDateString($request['target_date'] ?? null, 'ProgressionRequest.target_date');
        Validators::validateProgressionTypeValue($request['progression_type'] ?? null, 'ProgressionRequest.progression_type');
        Validators::validateOptionalDateTimeLocation($request['location'] ?? null, 'ProgressionRequest.location');

        return $this->http->post($this->buildUrl('progressions'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getDirections(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'DirectionRequest.subject');
        Validators::validateIsoDateString($request['target_date'] ?? null, 'DirectionRequest.target_date');
        Validators::validateDirectionTypeValue($request['direction_type'] ?? null, 'DirectionRequest.direction_type');
        Validators::validateArcRate($request['arc_rate'] ?? null, 'DirectionRequest.arc_rate');

        return $this->http->post($this->buildUrl('directions'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getNatalTransits(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'NatalTransitRequest.subject');
        Validators::validateOptionalDateRange($request['date_range'] ?? null, 'NatalTransitRequest.date_range');
        Validators::validateOrbValue($request['orb'] ?? null, 'NatalTransitRequest.orb');

        return $this->http->post($this->buildUrl('natal-transits'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getVenusReturnChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VenusReturnRequest.subject');
        Validators::validateReturnYear($request['return_year'] ?? null, 'VenusReturnRequest.return_year');
        Validators::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'VenusReturnRequest.return_location');

        return $this->http->post($this->buildUrl('venus-return'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getVenusReturnTransits(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VenusReturnTransitRequest.subject');
        Validators::validateReturnYear($request['return_year'] ?? null, 'VenusReturnTransitRequest.return_year');
        Validators::validateOptionalDateTimeLocation($request['return_location'] ?? null, 'VenusReturnTransitRequest.return_location');
        Validators::validateDateRange($request['date_range'] ?? [], 'VenusReturnTransitRequest.date_range');
        Validators::validateOrbValue($request['orb'] ?? null, 'VenusReturnTransitRequest.orb');

        return $this->http->post($this->buildUrl('venus-return-transits'), $request, $options);
    }
}
