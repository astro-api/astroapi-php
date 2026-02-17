<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Vedic astrology endpoints covering charts, dashas, doshas, and predictions.
 */
final class VedicClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/vedic';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VedicChartRequest.subject');

        return $this->http->post($this->buildUrl('chart'), $request, $options);
    }

    public function getBirthDetails(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VedicBirthDetailsRequest.subject');

        return $this->http->post($this->buildUrl('birth-details'), $request, $options);
    }

    public function getPanchang(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('panchang'), $request, $options);
    }

    public function getRegionalPanchang(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('panchang', 'regional'), $request, $options);
    }

    public function getKundliMatching(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('kundli-matching'), $request, $options);
    }

    public function getManglikDosha(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ManglikDoshaRequest.subject');

        return $this->http->post($this->buildUrl('manglik-dosha'), $request, $options);
    }

    public function getSadeSati(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'SadeSatiRequest.subject');

        return $this->http->post($this->buildUrl('sade-sati'), $request, $options);
    }

    public function getKaalSarpaDosha(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'KaalSarpaDoshaRequest.subject');

        return $this->http->post($this->buildUrl('kaal-sarpa-dosha'), $request, $options);
    }

    public function getVimshottariDasha(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VimshottariDashaRequest.subject');

        return $this->http->post($this->buildUrl('vimshottari-dasha'), $request, $options);
    }

    public function getYoginiDasha(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'YoginiDashaRequest.subject');

        return $this->http->post($this->buildUrl('yogini-dasha'), $request, $options);
    }

    public function getCharaDasha(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'CharaDashaRequest.subject');

        return $this->http->post($this->buildUrl('chara-dasha'), $request, $options);
    }

    public function getNakshatraPredictions(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'NakshatraPredictionsRequest.subject');

        return $this->http->post($this->buildUrl('nakshatra-predictions'), $request, $options);
    }

    public function getYogaAnalysis(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'YogaAnalysisRequest.subject');

        return $this->http->post($this->buildUrl('yoga-analysis'), $request, $options);
    }

    public function getShadbala(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'ShadbalaRequest.subject');

        return $this->http->post($this->buildUrl('shadbala'), $request, $options);
    }

    public function getAshtakvarga(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'AshtakvargaRequest.subject');

        return $this->http->post($this->buildUrl('ashtakvarga'), $request, $options);
    }

    public function getDivisionalChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'DivisionalChartRequest.subject');

        return $this->http->post($this->buildUrl('divisional-chart'), $request, $options);
    }

    public function getKPSystem(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'KPSystemRequest.subject');

        return $this->http->post($this->buildUrl('kp-system'), $request, $options);
    }

    public function getRemedies(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'RemediesRequest.subject');

        return $this->http->post($this->buildUrl('remedies'), $request, $options);
    }

    public function getVarshaphal(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VarshaphalRequest.subject');

        return $this->http->post($this->buildUrl('varshaphal'), $request, $options);
    }

    public function getTransit(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'VedicTransitRequest.subject');

        return $this->http->post($this->buildUrl('transit'), $request, $options);
    }

    public function getFestivalCalendar(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('festival-calendar'), $request, $options);
    }

    public function renderChart(string $format, array $request, array $options = []): mixed
    {
        $normalized = rawurlencode(trim($format));
        if ($normalized === '') {
            throw new \InvalidArgumentException('format must be a non-empty string.');
        }

        Validators::validateSubject($request['subject'] ?? [], 'VedicRenderChartRequest.subject');

        return $this->http->post($this->buildUrl('chart', 'render', $normalized), $request, $options);
    }
}
