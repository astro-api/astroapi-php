<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * PDF generation endpoints for natal reports and horoscopes.
 */
final class PdfClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/pdf';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getNatalReport(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PdfNatalReportRequest.subject');

        return $this->http->post($this->buildUrl('natal-report'), $request, $options);
    }

    public function getDailyHoroscope(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('daily-horoscope'), $request, $options);
    }

    public function getWeeklyHoroscope(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('weekly-horoscope'), $request, $options);
    }

    public function getHoroscopeData(string $sign, string $targetDate, array $options = []): mixed
    {
        $normalizedSign = rawurlencode(trim($sign));
        $normalizedDate = rawurlencode(trim($targetDate));

        if ($normalizedSign === '' || $normalizedDate === '') {
            throw new \InvalidArgumentException('sign and targetDate must be non-empty strings.');
        }

        return $this->http->get($this->buildUrl('horoscope', 'data', $normalizedSign, $normalizedDate), null, $options);
    }
}
