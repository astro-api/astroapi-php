<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Analysis category client providing access to report endpoints.
 */
final class AnalysisClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/analysis';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getNatalReport(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('natal-report'), $request, $options);
    }

    public function getSynastryReport(array $request, array $options = []): mixed
    {
        Validators::validateSynastryReportRequest($request);

        return $this->http->post($this->buildUrl('synastry-report'), $request, $options);
    }

    public function getCompositeReport(array $request, array $options = []): mixed
    {
        Validators::validateCompositeReportRequest($request);

        return $this->http->post($this->buildUrl('composite-report'), $request, $options);
    }

    public function getCompatibilityAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateCompatibilityRequest($request);

        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }

    public function getCompatibilityScore(array $request, array $options = []): mixed
    {
        Validators::validateSynastryChartRequest($request, 'CompatibilityScoreRequest');

        return $this->http->post($this->buildUrl('compatibility-score'), $request, $options);
    }

    public function getRelationshipAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest($request);

        return $this->http->post($this->buildUrl('relationship'), $request, $options);
    }

    public function getRelationshipScore(array $request, array $options = []): mixed
    {
        Validators::validateSynastryChartRequest($request, 'RelationshipScoreRequest');

        return $this->http->post($this->buildUrl('relationship-score'), $request, $options);
    }

    public function getTransitReport(array $request, array $options = []): mixed
    {
        Validators::validateNatalTransitRequest($request);

        return $this->http->post($this->buildUrl('transit-report'), $request, $options);
    }

    public function getNatalTransitReport(array $request, array $options = []): mixed
    {
        Validators::validateNatalTransitRequest($request);

        return $this->http->post($this->buildUrl('natal-transit-report'), $request, $options);
    }

    public function getProgressionReport(array $request, array $options = []): mixed
    {
        Validators::validateProgressionReportRequest($request);

        return $this->http->post($this->buildUrl('progression-report'), $request, $options);
    }

    public function getDirectionReport(array $request, array $options = []): mixed
    {
        Validators::validateDirectionReportRequest($request);

        return $this->http->post($this->buildUrl('direction-report'), $request, $options);
    }

    public function getLunarReturnReport(array $request, array $options = []): mixed
    {
        Validators::validateLunarReturnReportRequest($request);

        return $this->http->post($this->buildUrl('lunar-return-report'), $request, $options);
    }

    public function getSolarReturnReport(array $request, array $options = []): mixed
    {
        Validators::validateSolarReturnReportRequest($request);

        return $this->http->post($this->buildUrl('solar-return-report'), $request, $options);
    }

    public function getLunarReturnTransitReport(array $request, array $options = []): mixed
    {
        Validators::validateLunarReturnTransitRequest($request);

        return $this->http->post($this->buildUrl('lunar-return-transit-report'), $request, $options);
    }

    public function getSolarReturnTransitReport(array $request, array $options = []): mixed
    {
        Validators::validateSolarReturnTransitRequest($request);

        return $this->http->post($this->buildUrl('solar-return-transit-report'), $request, $options);
    }

    public function getCareerAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('career'), $request, $options);
    }

    public function getHealthAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('health'), $request, $options);
    }

    public function getKarmicAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('karmic'), $request, $options);
    }

    public function getPsychologicalAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('psychological'), $request, $options);
    }

    public function getSpiritualAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('spiritual'), $request, $options);
    }

    public function getPredictiveAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalTransitRequest($request);

        return $this->http->post($this->buildUrl('predictive'), $request, $options);
    }

    public function getVocationalAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('vocational'), $request, $options);
    }

    public function getLunarAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateLunarAnalysisRequest($request);

        return $this->http->post($this->buildUrl('lunar-analysis'), $request, $options);
    }

    public function getRelocationAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateNatalReportRequest($request);

        return $this->http->post($this->buildUrl('relocation'), $request, $options);
    }

    public function getVenusReturnReport(array $request, array $options = []): mixed
    {
        Validators::validateVenusReturnReportRequest($request);

        return $this->http->post($this->buildUrl('venus-return-report'), $request, $options);
    }

    public function getVenusReturnTransitReport(array $request, array $options = []): mixed
    {
        Validators::validateVenusReturnTransitRequest($request);

        return $this->http->post($this->buildUrl('venus-return-transit-report'), $request, $options);
    }
}
