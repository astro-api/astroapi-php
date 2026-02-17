<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Human Design endpoints covering bodygraph, compatibility, and glossary.
 */
final class HumanDesignClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/human-design';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getBodygraph(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'HumanDesignBodygraphRequest.subject');

        return $this->http->post($this->buildUrl('bodygraph'), $request, $options);
    }

    public function getCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }

    public function getDesignDate(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'HumanDesignDateRequest.subject');

        return $this->http->post($this->buildUrl('design-date'), $request, $options);
    }

    public function getTransits(array $request, array $options = []): mixed
    {
        return $this->http->post($this->buildUrl('transits'), $request, $options);
    }

    public function getType(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'HumanDesignTypeRequest.subject');

        return $this->http->post($this->buildUrl('type'), $request, $options);
    }

    public function getGlossaryChannels(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'channels'), null, $options);
    }

    public function getGlossaryGates(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'gates'), null, $options);
    }

    public function getGlossaryTypes(array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary', 'types'), null, $options);
    }
}
