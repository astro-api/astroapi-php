<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Lunar endpoints for phases, events, mansions, void-of-course, and calendar data.
 */
final class LunarClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/lunar';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getPhases(array $request, array $options = []): mixed
    {
        Validators::validateDateTimeLocation($request['datetime_location'] ?? [], 'LunarPhasesRequest.datetime_location');

        return $this->http->post($this->buildUrl('phases'), $request, $options);
    }

    public function getEvents(array $request, array $options = []): mixed
    {
        Validators::validateDateTimeLocation($request['datetime_location'] ?? [], 'LunarEventsRequest.datetime_location');

        return $this->http->post($this->buildUrl('events'), $request, $options);
    }

    public function getMansions(array $request, array $options = []): mixed
    {
        Validators::validateDateTimeLocation($request['datetime_location'] ?? [], 'LunarMansionsRequest.datetime_location');

        return $this->http->post($this->buildUrl('mansions'), $request, $options);
    }

    public function getVoidOfCourse(array $request, array $options = []): mixed
    {
        Validators::validateDateTimeLocation($request['datetime_location'] ?? [], 'VoidOfCourseRequest.datetime_location');

        return $this->http->post($this->buildUrl('void-of-course'), $request, $options);
    }

    public function getCalendar(int $year, ?array $params = null, array $options = []): mixed
    {
        $query = $this->mergeQuery($params, $options, $optionsOut);

        return $this->http->get($this->buildUrl('calendar', (string) $year), $query, $optionsOut);
    }

    /**
     * @param array<string, mixed>|null $params
     * @param array<string, mixed>      $options
     * @param array<string, mixed>      $optionsOut
     */
    private function mergeQuery(?array $params, array $options, ?array &$optionsOut): ?array
    {
        $existingQuery = [];
        if (isset($options['query']) && is_array($options['query'])) {
            $existingQuery = $options['query'];
            unset($options['query']);
        }

        $query = array_merge($existingQuery, $params ?? []);
        $optionsOut = $options;

        return $query === [] ? null : $query;
    }
}
