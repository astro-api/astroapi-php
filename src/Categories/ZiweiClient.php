<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Zi Wei Dou Shu (Purple Star Astrology) endpoint.
 */
final class ZiweiClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/ziwei';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ZiweiChartRequest.subject');

        return $this->http->post($this->buildUrl('chart'), $request, $options);
    }
}
