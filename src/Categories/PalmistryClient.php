<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Palmistry endpoints covering palm analysis, astro-analysis, and compatibility.
 */
final class PalmistryClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/palmistry';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getAnalysis(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('analysis'), $request, $options);
    }

    public function getAstroAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PalmistryAstroAnalysisRequest.subject');

        return $this->http->post($this->buildUrl('astro-analysis'), $request, $options);
    }

    public function getCompatibility(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }

    public function getReading(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('reading'), $request, $options);
    }
}
