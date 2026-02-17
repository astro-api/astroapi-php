<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;

/**
 * Feng Shui endpoints covering afflictions, flying stars, and glossary.
 */
final class FengshuiClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/fengshui';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getAfflictions(int $year, array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('afflictions', (string) $year), null, $options);
    }

    public function getAnnualFlyingStars(int $year, array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('annual-flying-stars', (string) $year), null, $options);
    }

    public function getFlyingStarsChart(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('flying-stars-chart'), $request, $options);
    }

    public function getGlossaryStars(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'stars'), null, $options);
    }
}
