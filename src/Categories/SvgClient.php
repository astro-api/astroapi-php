<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * SVG endpoints for natal, synastry, composite, and transit charts.
 */
final class SvgClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/svg';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getNatalChartSvg(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'NatalChartSVGRequest.subject');

        return $this->http->post($this->buildUrl('natal'), $request, $options);
    }

    public function getSynastryChartSvg(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('synastry'), $request, $options);
    }

    public function getCompositeChartSvg(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('composite'), $request, $options);
    }

    public function getTransitChartSvg(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'TransitChartSVGRequest.subject');

        return $this->http->post($this->buildUrl('transit'), $request, $options);
    }
}
