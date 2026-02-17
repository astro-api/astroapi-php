<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Exceptions\AstrologyError;
use Procoders\AstrologyApi\Utils\GuzzleHttpHelper;

final class GuzzleHttpHelperTest extends TestCase
{
    public function testGetUnwrapsDataPayload(): void
    {
        $helper = $this->helper([new Response(200, ['Content-Type' => 'application/json'], json_encode(['data' => ['value' => 1]]))]);

        $result = $helper->get('/demo');

        self::assertSame(['value' => 1], $result);
    }

    public function testPostReturnsResultField(): void
    {
        $helper = $this->helper([new Response(200, ['Content-Type' => 'application/json'], json_encode(['result' => ['ok' => true]]))]);

        $result = $helper->post('/demo', ['foo' => 'bar']);

        self::assertSame(['ok' => true], $result);
    }

    public function testPutHandlesPlainJson(): void
    {
        $helper = $this->helper([new Response(200, ['Content-Type' => 'application/json'], json_encode(['value' => 7]))]);

        $result = $helper->put('/demo', ['test' => 1]);

        self::assertSame(['value' => 7], $result);
    }

    public function testDeleteHandlesTextResponse(): void
    {
        $helper = $this->helper([new Response(204, [], '')]);

        $result = $helper->delete('/demo');

        self::assertNull($result);
    }

    public function testErrorIsConvertedToAstrologyError(): void
    {
        $helper = $this->helper([new Response(500, [], 'server error')]);

        $this->expectException(AstrologyError::class);
        $helper->get('/fail');
    }

    private function helper(array $responses): GuzzleHttpHelper
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $client = new Client(['handler' => $stack]);

        return new GuzzleHttpHelper($client);
    }
}
