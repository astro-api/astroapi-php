<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\KabbalahClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class KabbalahClientTest extends TestCase
{
    private KabbalahClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new KabbalahClient($this->http);
    }

    public function testGetBirthAngels(): void
    {
        $this->client->getBirthAngels(['subject' => $this->subject()]);

        self::assertSame('/api/v3/kabbalah/birth-angels', $this->http->lastPath);
    }

    public function testGetGematria(): void
    {
        $this->client->getGematria(['text' => 'hello']);

        self::assertSame('/api/v3/kabbalah/gematria', $this->http->lastPath);
    }

    public function testGetTikkun(): void
    {
        $this->client->getTikkun(['subject' => $this->subject()]);

        self::assertSame('/api/v3/kabbalah/tikkun', $this->http->lastPath);
    }

    public function testGetTreeOfLifeChart(): void
    {
        $this->client->getTreeOfLifeChart(['subject' => $this->subject()]);

        self::assertSame('/api/v3/kabbalah/tree-of-life', $this->http->lastPath);
    }

    public function testGetGlossaryAngels72(): void
    {
        $this->client->getGlossaryAngels72();

        self::assertSame('/api/v3/kabbalah/glossary/angels-72', $this->http->lastPath);
        self::assertSame('GET', $this->http->lastMethod);
    }

    public function testGetGlossaryHebrewLetters(): void
    {
        $this->client->getGlossaryHebrewLetters();

        self::assertSame('/api/v3/kabbalah/glossary/hebrew-letters', $this->http->lastPath);
    }

    public function testGetGlossarySephiroth(): void
    {
        $this->client->getGlossarySephiroth();

        self::assertSame('/api/v3/kabbalah/glossary/sephiroth', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Kabbalah User',
            'birth_data' => [
                'year' => 1988,
                'month' => 11,
                'day' => 7,
                'hour' => 8,
                'minute' => 0,
                'second' => 0,
            ],
        ];
    }
}
