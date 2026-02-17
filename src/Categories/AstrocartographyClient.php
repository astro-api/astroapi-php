<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Astrocartography endpoints covering lines, maps, and location analysis.
 */
final class AstrocartographyClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/astrocartography';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getLines(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AstrocartographyLinesRequest.subject');

        return $this->http->post($this->buildUrl('lines'), $request, $options);
    }

    public function generateMap(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AstrocartographyMapRequest.subject');

        return $this->http->post($this->buildUrl('map'), $request, $options);
    }

    public function generateParanMap(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ParanMapRequest.subject');

        return $this->http->post($this->buildUrl('paran-map'), $request, $options);
    }

    public function analyzeLocation(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'LocationAnalysisRequest.subject');

        return $this->http->post($this->buildUrl('location-analysis'), $request, $options);
    }

    public function compareLocations(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'CompareLocationsRequest.subject');

        return $this->http->post($this->buildUrl('compare-locations'), $request, $options);
    }

    public function findPowerZones(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PowerZonesRequest.subject');

        return $this->http->post($this->buildUrl('power-zones'), $request, $options);
    }

    public function searchLocations(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'SearchLocationsRequest.subject');

        return $this->http->post($this->buildUrl('search-locations'), $request, $options);
    }

    public function generateRelocationChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'RelocationChartRequest.subject');

        return $this->http->post($this->buildUrl('relocation-chart'), $request, $options);
    }

    public function getLineMeanings(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('line-meanings'), null, $options);
    }

    public function getSupportedFeatures(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('supported-features'), null, $options);
    }

    public function getAstrodynes(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AstrodynesRequest.subject');

        return $this->http->post($this->buildUrl('astrodynes'), $request, $options);
    }

    public function compareAstrodynes(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'CompareAstrodynesRequest.subject');

        return $this->http->post($this->buildUrl('astrodynes', 'compare'), $request, $options);
    }

    public function render(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AstrocartographyRenderRequest.subject');

        return $this->http->post($this->buildUrl('render'), $request, $options);
    }
}
