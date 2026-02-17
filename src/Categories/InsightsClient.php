<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;

/**
 * Insights endpoints organised by relationship, pet, wellness, financial, and business subdomains.
 */
final class InsightsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/insights';

    public readonly RelationshipInsightsClient $relationship;
    public readonly PetInsightsClient $pet;
    public readonly WellnessInsightsClient $wellness;
    public readonly FinancialInsightsClient $financial;
    public readonly BusinessInsightsClient $business;

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
        $this->relationship = new RelationshipInsightsClient($http);
        $this->pet = new PetInsightsClient($http);
        $this->wellness = new WellnessInsightsClient($http);
        $this->financial = new FinancialInsightsClient($http);
        $this->business = new BusinessInsightsClient($http);
    }

    public function discover(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl(), null, $options);
    }
}
