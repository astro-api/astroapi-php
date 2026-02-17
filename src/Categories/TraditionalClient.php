<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Traditional astrology endpoints (dignities, lots, profections, glossary).
 */
final class TraditionalClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/traditional';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'TraditionalAnalysisRequest.subject');

        return $this->http->post($this->buildUrl('analysis'), $request, $options);
    }

    public function getDignitiesAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'TraditionalDignitiesRequest.subject');

        return $this->http->post($this->buildUrl('dignities'), $request, $options);
    }

    public function getLotsAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'TraditionalLotsRequest.subject');

        return $this->http->post($this->buildUrl('lots'), $request, $options);
    }

    public function getProfectionsAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'TraditionalProfectionsRequest.subject');

        return $this->http->post($this->buildUrl('profections'), $request, $options);
    }

    public function getAnnualProfection(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AnnualProfectionRequest.subject');

        return $this->http->post($this->buildUrl('analysis', 'annual-profection'), $request, $options);
    }

    public function getProfectionTimeline(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ProfectionTimelineRequest.subject');

        return $this->http->post($this->buildUrl('analysis', 'profection-timeline'), $request, $options);
    }

    public function getTraditionalPointsGlossary(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'traditional-points'), null, $options);
    }

    public function getDignitiesGlossary(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'dignities'), null, $options);
    }

    public function getProfectionHousesGlossary(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'profection-houses'), null, $options);
    }

    public function getCapabilities(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('capabilities'), null, $options);
    }
}
