<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Eclipses endpoints for upcoming events and personal interpretations.
 */
final class EclipsesClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/eclipses';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getUpcoming(?array $params = null, array $options = []): mixed
    {
        [$query, $optionsOut] = $this->mergeQuery($params, $options);

        return $this->http->get($this->buildUrl('upcoming'), $query, $optionsOut);
    }

    public function checkNatalImpact(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'EclipseNatalCheckRequest.subject');

        return $this->http->post($this->buildUrl('natal-check'), $request, $options);
    }

    public function getInterpretation(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'EclipseInterpretationRequest.subject');

        return $this->http->post($this->buildUrl('interpretation'), $request, $options);
    }

    /**
     * @param array<string, mixed>|null $params
     * @param array<string, mixed>      $options
     *
     * @return array{0: array<string, mixed>|null, 1: array<string, mixed>}
     */
    private function mergeQuery(?array $params, array $options): array
    {
        $query = [];
        if (isset($options['query']) && is_array($options['query'])) {
            $query = $options['query'];
            unset($options['query']);
        }

        if ($params !== null) {
            $query = array_merge($query, $params);
        }

        return [$query === [] ? null : $query, $options];
    }
}
