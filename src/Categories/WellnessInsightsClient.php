<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Wellness insights subdomain endpoints.
 */
final class WellnessInsightsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/insights/wellness';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getBodyMapping(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'WellnessBodyMappingRequest.subject');

        return $this->http->post($this->buildUrl('body-mapping'), $request, $options);
    }

    public function getBiorhythms(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'WellnessBiorhythmsRequest.subject');

        return $this->http->post($this->buildUrl('biorhythms'), $request, $options);
    }

    public function getWellnessTiming(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'WellnessTimingRequest.subject');

        return $this->http->post($this->buildUrl('wellness-timing'), $request, $options);
    }

    public function getEnergyPatterns(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'WellnessEnergyPatternsRequest.subject');

        return $this->http->post($this->buildUrl('energy-patterns'), $request, $options);
    }

    public function getWellnessScore(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'WellnessScoreRequest.subject');

        return $this->http->post($this->buildUrl('wellness-score'), $request, $options);
    }

    public function getMoonWellness(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'MoonWellnessRequest.subject');

        return $this->http->post($this->buildUrl('moon-wellness'), $request, $options);
    }
}
