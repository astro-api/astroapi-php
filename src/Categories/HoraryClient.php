<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Horary astrology endpoints covering chart analysis, aspects, and fertility.
 */
final class HoraryClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/horary';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function analyze(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('analyze'), $request, $options);
    }

    public function getAspects(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('aspects'), $request, $options);
    }

    public function getChart(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('chart'), $request, $options);
    }

    public function getFertilityAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'HoraryFertilityRequest.subject');

        return $this->http->post($this->buildUrl('fertility'), $request, $options);
    }

    public function getGlossaryCategories(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'categories'), null, $options);
    }

    public function getGlossaryConsiderations(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'considerations'), null, $options);
    }
}
