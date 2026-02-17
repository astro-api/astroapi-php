<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;

/**
 * Health check and diagnostic endpoints.
 */
final class HealthClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/health';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function check(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl(), null, $options);
    }

    public function debugTimezone(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('debug', 'timezone'), null, $options);
    }
}
