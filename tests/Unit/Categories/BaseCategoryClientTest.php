<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\BaseCategoryClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class BaseCategoryClientTest extends TestCase
{
    public function testBuildUrlNormalisesSegments(): void
    {
        $client = new class (new SpyHttpHelper()) extends BaseCategoryClient {
            public function __construct(SpyHttpHelper $http)
            {
                parent::__construct($http, '/api/v3/demo');
            }

            public function path(string ...$segments): string
            {
                return $this->buildUrl(...$segments);
            }
        };

        self::assertSame('/api/v3/demo/foo/bar', $client->path('/foo/', '/bar'));
    }
}
