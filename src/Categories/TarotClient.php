<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Tarot endpoints providing glossary, drawing, and analytical reports.
 */
final class TarotClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/tarot';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getCardsGlossary(?array $params = null, array $options = []): mixed
    {
        [$query, $optionsOut] = $this->mergeQuery($params, $options);

        return $this->http->get($this->buildUrl('glossary', 'cards'), $query, $optionsOut);
    }

    public function getSpreadsGlossary(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'spreads'), null, $options);
    }

    public function getCardDetails(string $cardId, array $options = []): mixed
    {
        $normalized = rawurlencode(trim($cardId));
        if ($normalized === '') {
            throw new \InvalidArgumentException('cardId must be a non-empty string.');
        }

        return $this->http->get($this->buildUrl('glossary', 'cards', $normalized), null, $options);
    }

    public function drawCards(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('cards', 'draw'), $request, $options);
    }

    public function searchCards(?array $params = null, array $options = []): mixed
    {
        [$query, $optionsOut] = $this->mergeQuery($params, $options);

        return $this->http->get($this->buildUrl('cards', 'search'), $query, $optionsOut);
    }

    public function getDailyCard(array $params, array $options = []): mixed
    {
        [$query, $optionsOut] = $this->mergeQuery($params, $options);

        return $this->http->get($this->buildUrl('cards', 'daily'), $query, $optionsOut);
    }

    public function generateSingleReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('reports', 'single'), $request, $options);
    }

    public function generateThreeCardReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('reports', 'three-card'), $request, $options);
    }

    public function generateCelticCrossReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('reports', 'celtic-cross'), $request, $options);
    }

    public function generateSynastryReport(array $request, array $options = []): mixed
    {
        $this->validateRelationshipIfPresent($request);

        return $this->http->post($this->buildUrl('reports', 'synastry'), $request, $options);
    }

    public function generateHousesReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('reports', 'houses'), $request, $options);
    }

    public function generateTreeOfLifeReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('reports', 'tree-of-life'), $request, $options);
    }

    public function calculateQuintessence(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('analysis', 'quintessence'), $request, $options);
    }

    public function calculateBirthCards(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('analysis', 'birth-cards'), $request, $options);
    }

    public function calculateElementalDignities(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('analysis', 'dignities'), $request, $options);
    }

    public function analyzeTiming(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('analysis', 'timing'), $request, $options);
    }

    public function calculateOptimalTimes(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('analysis', 'optimal-times'), $request, $options);
    }

    public function generateTransitReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('analysis', 'transit-report'), $request, $options);
    }

    public function generateNatalReport(array $request, array $options = []): mixed
    {
        $this->validateSubjectsIfPresent($request);

        return $this->http->post($this->buildUrl('analysis', 'natal-report'), $request, $options);
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

    /**
     * @param array<string, mixed> $request
     */
    private function validateSubjectsIfPresent(array $request): void
    {
        if (isset($request['subject']) && is_array($request['subject'])) {
            Validators::validateSubject($request['subject'], 'TarotRequest.subject');
        }

        if (isset($request['subjects']) && is_array($request['subjects'])) {
            Validators::validateRelationshipAnalysisRequest([
                'subjects' => $request['subjects'],
            ]);
        }
    }

    /**
     * @param array<string, mixed> $request
     */
    private function validateRelationshipIfPresent(array $request): void
    {
        if (isset($request['subjects']) && is_array($request['subjects'])) {
            Validators::validateRelationshipAnalysisRequest([
                'subjects' => $request['subjects'],
            ]);
        } elseif (isset($request['subject1'], $request['subject2'])) {
            Validators::validateSubject($request['subject1'], 'TarotSynastry.subject1');
            Validators::validateSubject($request['subject2'], 'TarotSynastry.subject2');
        }
    }
}
