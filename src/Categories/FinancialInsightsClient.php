<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Financial insights subdomain endpoints.
 */
final class FinancialInsightsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/insights/financial';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getMarketTiming(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('market-timing'), $request, $options);
    }

    public function analyzePersonalTrading(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PersonalTradingRequest.subject');

        return $this->http->post($this->buildUrl('personal-trading'), $request, $options);
    }

    public function getGannAnalysis(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('gann-analysis'), $request, $options);
    }

    public function getBradleySiderograph(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('bradley-siderograph'), $request, $options);
    }

    public function getCryptoTiming(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('crypto-timing'), $request, $options);
    }

    public function getForexTiming(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('forex-timing'), $request, $options);
    }
}
