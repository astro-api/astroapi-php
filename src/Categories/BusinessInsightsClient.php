<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Business insights subdomain endpoints.
 */
final class BusinessInsightsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/insights/business';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getTeamDynamics(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('team-dynamics'), $request, $options);
    }

    public function getHiringWindow(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'BusinessHiringWindowRequest.subject');

        return $this->http->post($this->buildUrl('hiring-window'), $request, $options);
    }

    public function getInvestmentTiming(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('investment-timing'), $request, $options);
    }

    public function getProductLaunch(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('product-launch'), $request, $options);
    }

    public function getBusinessTiming(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('business-timing'), $request, $options);
    }

    public function getDepartmentCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('department-compatibility'), $request, $options);
    }

    public function getHiringCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('hiring-compatibility'), $request, $options);
    }

    public function getLeadershipStyle(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'BusinessLeadershipStyleRequest.subject');

        return $this->http->post($this->buildUrl('leadership-style'), $request, $options);
    }

    public function getSuccessionPlanning(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('succession-planning'), $request, $options);
    }
}
