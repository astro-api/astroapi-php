<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Data category endpoints.
 */
final class DataClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/data';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPositions(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PlanetaryPositionsRequest.subject');

        return $this->http->post($this->buildUrl('positions'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getEnhancedPositions(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'EnhancedPositionsRequest.subject');

        return $this->http->post($this->buildUrl('positions', 'enhanced'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getGlobalPositions(array $request, array $options = []): mixed
    {
        Validators::validateGlobalDataRequest($request, 'GlobalDataRequest');

        return $this->http->post($this->buildUrl('global-positions'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getAspects(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AspectsRequest.subject');

        return $this->http->post($this->buildUrl('aspects'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getEnhancedAspects(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'EnhancedAspectsRequest.subject');

        return $this->http->post($this->buildUrl('aspects', 'enhanced'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getHouseCusps(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'HouseCuspsRequest.subject');

        return $this->http->post($this->buildUrl('house-cusps'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getLunarMetrics(array $request, array $options = []): mixed
    {
        Validators::validateDateTimeLocation($request['datetime_location'] ?? [], 'LunarMetricsRequest.datetime_location');

        return $this->http->post($this->buildUrl('lunar-metrics'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getEnhancedLunarMetrics(array $request, array $options = []): mixed
    {
        Validators::validateDateTimeLocation($request['datetime_location'] ?? [], 'EnhancedLunarMetricsRequest.datetime_location');

        return $this->http->post($this->buildUrl('lunar-metrics', 'enhanced'), $request, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function getCurrentMoment(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('now'), null, $options);
    }
}
