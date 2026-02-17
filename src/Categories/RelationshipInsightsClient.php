<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Relationship insights subdomain endpoints.
 */
final class RelationshipInsightsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/insights/relationship';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }

    public function getCompatibilityScore(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('compatibility-score'), $request, $options);
    }

    public function getLoveLanguages(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'RelationshipLoveLanguagesRequest.subject');

        return $this->http->post($this->buildUrl('love-languages'), $request, $options);
    }

    public function getDavisonReport(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('davison'), $request, $options);
    }

    public function getTiming(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('timing'), $request, $options);
    }

    public function getRedFlags(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'RelationshipRedFlagsRequest.subject');

        return $this->http->post($this->buildUrl('red-flags'), $request, $options);
    }

    public function discover(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl(), null, $options);
    }
}
