<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Enhanced analysis endpoints (global and personal, plus chart variants).
 */
final class EnhancedClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/enhanced';
    private const ENHANCED_CHARTS_PREFIX = '/api/v3/enhanced_charts';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getGlobalAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'GlobalAnalysisRequest.subject');

        return $this->http->post($this->buildUrl('global-analysis'), $request, $options);
    }

    public function getPersonalAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PersonalAnalysisRequest.subject');

        return $this->http->post($this->buildUrl('personal-analysis'), $request, $options);
    }

    public function getGlobalAnalysisChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'GlobalAnalysisRequest.subject');

        return $this->http->post($this->buildCustomUrl(self::ENHANCED_CHARTS_PREFIX, 'global-analysis'), $request, $options);
    }

    public function getPersonalAnalysisChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PersonalAnalysisRequest.subject');

        return $this->http->post($this->buildCustomUrl(self::ENHANCED_CHARTS_PREFIX, 'personal-analysis'), $request, $options);
    }
}
