<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Glossary category client exposing metadata helper endpoints.
 */
final class GlossaryClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/glossary';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getActivePoints(?array $query = null, array $options = []): mixed
    {
        Validators::validateActivePointsQuery($query);

        return $this->http->get($this->buildUrl('active-points'), $query, $options);
    }

    public function getPrimaryActivePoints(?array $query = null, array $options = []): mixed
    {
        Validators::validatePrimaryActivePointsQuery($query);

        return $this->http->get($this->buildUrl('active-points', 'primary'), $query, $options);
    }

    public function getCities(array $params = [], array $options = []): mixed
    {
        Validators::validateCitySearchParams($params);

        return $this->http->get($this->buildUrl('cities'), $params, $options);
    }

    public function getCountries(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('countries'), null, $options);
    }

    public function getElements(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('elements'), null, $options);
    }

    public function getFixedStars(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('fixed-stars'), null, $options);
    }

    public function getHouseSystems(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('house-systems'), null, $options);
    }

    public function getHouses(?array $request = null, array $options = []): mixed
    {
        Validators::validateHousesRequest($request);

        return $this->http->get($this->buildUrl('houses'), $request, $options);
    }

    public function getKeywords(?array $request = null, array $options = []): mixed
    {
        Validators::validateKeywordsRequest($request);

        return $this->http->get($this->buildUrl('keywords'), $request, $options);
    }

    public function getLanguages(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('languages'), null, $options);
    }

    public function getLifeAreas(?array $request = null, array $options = []): mixed
    {
        Validators::validateLifeAreasRequest($request);

        return $this->http->get($this->buildUrl('life-areas'), $request, $options);
    }

    public function getThemes(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('themes'), null, $options);
    }

    public function getZodiacTypes(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('zodiac-types'), null, $options);
    }

    public function getHoraryCategories(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('horary-categories'), null, $options);
    }
}
