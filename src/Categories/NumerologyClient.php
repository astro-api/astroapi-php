<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Numerology endpoints for core numbers, comprehensive report, and compatibility.
 */
final class NumerologyClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/numerology';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getCoreNumbers(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'NumerologyCoreRequest.subject');

        return $this->http->post($this->buildUrl('core-numbers'), $request, $options);
    }

    public function getComprehensiveReport(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'NumerologyComprehensiveRequest.subject');

        return $this->http->post($this->buildUrl('comprehensive'), $request, $options);
    }

    public function analyzeCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }
}
