<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Kabbalah endpoints covering birth angels, gematria, tikkun, and glossary.
 */
final class KabbalahClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/kabbalah';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getBirthAngels(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'KabbalahBirthAngelsRequest.subject');

        return $this->http->post($this->buildUrl('birth-angels'), $request, $options);
    }

    public function getGematria(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('gematria'), $request, $options);
    }

    public function getTikkun(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'KabbalahTikkunRequest.subject');

        return $this->http->post($this->buildUrl('tikkun'), $request, $options);
    }

    public function getTreeOfLifeChart(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'KabbalahTreeOfLifeRequest.subject');

        return $this->http->post($this->buildUrl('tree-of-life'), $request, $options);
    }

    public function getGlossaryAngels72(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'angels-72'), null, $options);
    }

    public function getGlossaryHebrewLetters(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'hebrew-letters'), null, $options);
    }

    public function getGlossarySephiroth(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'sephiroth'), null, $options);
    }
}
