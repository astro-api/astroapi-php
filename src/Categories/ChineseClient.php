<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Chinese astrology endpoints (BaZi, compatibility, yearly forecasts, zodiac data).
 */
final class ChineseClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/chinese';
    private const ZODIAC_ANIMALS = [
        'rat', 'ox', 'tiger', 'rabbit', 'dragon', 'snake', 'horse', 'goat', 'monkey', 'rooster', 'dog', 'pig',
    ];

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function calculateBaZi(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'BaZiRequest.subject');

        return $this->http->post($this->buildUrl('bazi'), $request, $options);
    }

    public function calculateCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }

    public function calculateLuckPillars(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'LuckPillarsRequest.subject');

        return $this->http->post($this->buildUrl('luck-pillars'), $request, $options);
    }

    public function calculateMingGua(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'MingGuaRequest.subject');

        return $this->http->post($this->buildUrl('ming-gua'), $request, $options);
    }

    public function getYearlyForecast(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ChineseYearlyRequest.subject');

        return $this->http->post($this->buildUrl('yearly-forecast'), $request, $options);
    }

    public function analyzeYearElements(int $year, ?array $params = null, array $options = []): mixed
    {
        $query = $this->mergeQueryOptions($params, $options, $optionsOut);

        return $this->http->get($this->buildUrl('elements', 'balance', (string) $year), $query, $optionsOut);
    }

    public function getSolarTerms(int $year, ?array $params = null, array $options = []): mixed
    {
        $query = $this->mergeQueryOptions($params, $options, $optionsOut);

        return $this->http->get($this->buildUrl('calendar', 'solar-terms', (string) $year), $query, $optionsOut);
    }

    public function getZodiacAnimal(string $animal, ?array $params = null, array $options = []): mixed
    {
        $normalized = strtolower(trim($animal));
        if (!in_array($normalized, self::ZODIAC_ANIMALS, true)) {
            throw new \InvalidArgumentException('Unknown Chinese zodiac animal: ' . $animal);
        }

        $query = $this->mergeQueryOptions($params, $options, $optionsOut);

        return $this->http->get($this->buildUrl('zodiac', $normalized), $query, $optionsOut);
    }

    /**
     * @param array<string, mixed>|null $params
     * @param array<string, mixed>      $options
     * @param array<string, mixed>      $optionsOut
     *
     * @return array<string, mixed>|null
     */
    private function mergeQueryOptions(?array $params, array $options, ?array &$optionsOut): ?array
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
