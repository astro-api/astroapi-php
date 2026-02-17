<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Horoscope related endpoints.
 */
final class HoroscopeClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/horoscope';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalDailyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validatePersonalizedHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'daily'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalDailyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validatePersonalTextHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'daily', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignDailyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validateSunSignHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'daily'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignDailyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validateTextHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'daily', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignWeeklyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validateSunSignWeeklyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'weekly'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignWeeklyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validateTextWeeklyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'weekly', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignMonthlyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validateSunSignMonthlyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'monthly'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignMonthlyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validateTextMonthlyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'monthly', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignYearlyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validateSunSignYearlyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'yearly'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getSignYearlyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validateSignYearlyTextHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('sign', 'yearly', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalWeeklyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validatePersonalWeeklyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'weekly'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalWeeklyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validatePersonalWeeklyTextHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'weekly', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalMonthlyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validatePersonalMonthlyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'monthly'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalMonthlyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validatePersonalMonthlyTextHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'monthly', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalYearlyHoroscope(array $request, array $options = []): mixed
    {
        Validators::validatePersonalYearlyHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'yearly'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getPersonalYearlyHoroscopeText(array $request, array $options = []): mixed
    {
        Validators::validatePersonalYearlyTextHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('personal', 'yearly', 'text'), $request, $options);
    }

    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $options
     */
    public function getChineseHoroscope(array $request, array $options = []): mixed
    {
        Validators::validateChineseHoroscopeRequest($request);

        return $this->http->post($this->buildUrl('chinese', 'bazi'), $request, $options);
    }
}
