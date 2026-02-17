<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Chart rendering endpoints for natal, synastry, composite, and transit charts.
 */
final class RenderClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/render';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getNatalChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'RenderNatalChartRequest.subject');

        return $this->http->post($this->buildUrl('natal'), $request, $options);
    }

    public function getSynastryChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject1'] ?? [], 'RenderSynastryChartRequest.subject1');
        Validators::validateSubject($request['subject2'] ?? [], 'RenderSynastryChartRequest.subject2');

        return $this->http->post($this->buildUrl('synastry'), $request, $options);
    }

    public function getCompositeChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject1'] ?? [], 'RenderCompositeChartRequest.subject1');
        Validators::validateSubject($request['subject2'] ?? [], 'RenderCompositeChartRequest.subject2');

        return $this->http->post($this->buildUrl('composite'), $request, $options);
    }

    public function getTransitChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['natal_subject'] ?? [], 'RenderTransitChartRequest.natal_subject');

        return $this->http->post($this->buildUrl('transit'), $request, $options);
    }
}
