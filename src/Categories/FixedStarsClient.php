<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Fixed stars endpoints for positions, conjunctions, and reports.
 */
final class FixedStarsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/fixed-stars';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getPositions(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'FixedStarsPositionsRequest.subject');

        return $this->http->post($this->buildUrl('positions'), $request, $options);
    }

    public function getConjunctions(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'FixedStarsConjunctionsRequest.subject');

        return $this->http->post($this->buildUrl('conjunctions'), $request, $options);
    }

    public function generateReport(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'FixedStarsReportRequest.subject');

        return $this->http->post($this->buildUrl('report'), $request, $options);
    }

    public function getPresets(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('presets'), null, $options);
    }
}
