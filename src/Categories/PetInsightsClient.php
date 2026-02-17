<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

/**
 * Pet insights subdomain endpoints.
 */
final class PetInsightsClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/insights/pet';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    public function getPersonality(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PetPersonalityRequest.subject');

        return $this->http->post($this->buildUrl('personality'), $request, $options);
    }

    public function getCompatibility(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('compatibility'), $request, $options);
    }

    public function getTrainingWindows(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PetTrainingWindowsRequest.subject');

        return $this->http->post($this->buildUrl('training-windows'), $request, $options);
    }

    public function getHealthSensitivities(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'PetHealthSensitivitiesRequest.subject');

        return $this->http->post($this->buildUrl('health-sensitivities'), $request, $options);
    }

    public function getMultiPetDynamics(array $request, array $options = []): mixed
    {
        Validators::validateRelationshipAnalysisRequest([
            'subjects' => $request['subjects'] ?? [],
        ]);

        return $this->http->post($this->buildUrl('multi-pet-dynamics'), $request, $options);
    }
}
