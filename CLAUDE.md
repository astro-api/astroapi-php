# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

PHP 8.1+ SDK client for the Astrology API v3. Package: `procoders/astrology-api-php`. Uses Guzzle 7 for HTTP transport. This is a standalone library (no framework, no database). Repository: https://github.com/astro-api/astroapi-php

## Commands

```bash
composer install                    # Install dependencies
composer test                       # Full PHPUnit suite (unit + integration)
composer test:unit                  # Unit tests only (mocked, always pass)
composer test:integration           # Integration tests only (requires API key)
composer lint                       # Check code style (dry-run)
composer lint:fix                   # Auto-fix code style
composer coverage                   # HTML report in coverage/ + text output

# Single test file
vendor/bin/phpunit tests/Unit/Categories/ChartsClientTest.php

# Single test method
vendor/bin/phpunit --filter testNatalChart
```

If `php-cs-fixer` complains about PHP version, prefix with `PHP_CS_FIXER_IGNORE_ENV=1`.

## Architecture

```
src/
├── AstrologyClient.php              # Entry point. Creates Guzzle + 26 category clients
├── Categories/
│   ├── BaseCategoryClient.php       # Abstract base. buildUrl(), buildCustomUrl()
│   ├── ChartsClient.php             # Canonical example of a category client
│   ├── InsightsClient.php           # Special: 5 nested sub-clients
│   ├── RelationshipInsightsClient.php  # Sub-client of InsightsClient
│   └── ...                          # 31 client files total
├── Config/
│   ├── AstrologyClientConfig.php    # Readonly config. Reads env vars
│   └── RetryConfig.php              # Readonly retry value object
├── Exceptions/
│   └── AstrologyError.php           # Single exception type
└── Utils/
    ├── HttpHelper.php               # Interface: get/post/put/delete
    ├── GuzzleHttpHelper.php         # Guzzle implementation
    └── Validators.php               # Static validation (all business rules)
```

**Data flow:** `CategoryClient method` -> `Validators::validate*()` -> `$this->http->post()` -> `GuzzleHttpHelper` -> Guzzle -> API

**Response normalization:** `GuzzleHttpHelper` extracts `data` or `result` key from JSON responses automatically. Non-JSON responses return raw string. Empty bodies return `null`.

**Middleware stack** (in AstrologyClient, push order): retry -> API key injection -> debug logging.

## Code Conventions

1. **Every file** starts with `declare(strict_types=1)`
2. **All classes are `final`** unless they need inheritance (`BaseCategoryClient`, `IntegrationTestCase`)
3. **PSR-12** enforced by `.php-cs-fixer.php` (also: single quotes, short array syntax, strict params)
4. **Readonly properties** for all immutable state (PHP 8.1+)
5. **No return type annotations on category client methods** — return `mixed`
6. **`$options` is always the last parameter** on public category client methods
7. **Validation context strings** use `ClassName.fieldName` format: `'NatalChartRequest.subject'`
8. **Only exception type:** `AstrologyError` — never throw anything else from SDK code
9. PSR-4 autoloading: `Procoders\AstrologyApi\` -> `src/`, `Procoders\AstrologyApi\Tests\` -> `tests/`

## Category Client Template

When adding a new category client, follow this exact pattern:

```php
<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Categories;

use Procoders\AstrologyApi\Utils\HttpHelper;
use Procoders\AstrologyApi\Utils\Validators;

final class FooClient extends BaseCategoryClient
{
    private const API_PREFIX = '/api/v3/foo';

    public function __construct(HttpHelper $http)
    {
        parent::__construct($http, self::API_PREFIX);
    }

    /** @param array<string, mixed> $request */
    public function getBar(array $request, array $options = []): mixed
    {
        Validators::validateSubject($request['subject'] ?? [], 'BarRequest.subject');

        return $this->http->post($this->buildUrl('bar'), $request, $options);
    }

    // GET endpoints (no body, optional query):
    public function getGlossary(?array $query = null, array $options = []): mixed
    {
        return $this->http->get($this->buildUrl('glossary'), $query, $options);
    }
}
```

**Then register it in `AstrologyClient.php`:**
1. Add `use Procoders\AstrologyApi\Categories\FooClient;`
2. Add `public readonly FooClient $foo;` property
3. Add `$this->foo = new FooClient($this->httpHelper);` in constructor

## Unit Test Template

```php
<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Unit\Categories;

use PHPUnit\Framework\TestCase;
use Procoders\AstrologyApi\Categories\FooClient;
use Procoders\AstrologyApi\Tests\Support\SpyHttpHelper;

final class FooClientTest extends TestCase
{
    private FooClient $client;
    private SpyHttpHelper $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = new SpyHttpHelper();
        $this->client = new FooClient($this->http);
    }

    public function testGetBar(): void
    {
        $this->client->getBar(['subject' => $this->subject()]);

        self::assertSame('/api/v3/foo/bar', $this->http->lastPath);
    }

    private function subject(): array
    {
        return [
            'name' => 'Sample',
            'birth_data' => [
                'year' => 1988, 'month' => 1, 'day' => 2,
                'hour' => 0, 'minute' => 0, 'second' => 0,
            ],
        ];
    }
}
```

**`SpyHttpHelper`** captures: `lastMethod`, `lastPath`, `lastPayload`, `lastQuery`, `lastOptions`. Unit tests assert URL construction and HTTP method. No real HTTP calls.

## Integration Test Template

```php
<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi\Tests\Integration\Categories;

use Procoders\AstrologyApi\Tests\Integration\IntegrationTestCase;

final class FooClientTest extends IntegrationTestCase
{
    public function testGetBar(): void
    {
        $response = self::$client->foo->getBar([
            'subject' => $this->subject(),
        ]);

        $this->assertSuccessResponse($response);
    }
}
```

Auto-skips when `ASTROLOGY_API_KEY` env var is absent. `IntegrationTestCase` provides: `subject()`, `secondSubject()`, `dateTimeLocation()`, `assertSuccessResponse()`.

**Important:** The real API requires location data **inside** `birth_data` (latitude, longitude, city, nation, timezone). Unit test subjects don't need location; integration test subjects do.

## Validation Rules Reference

**Subject** (`validateSubject`): requires `birth_data` with `year` (1900-2100), `month` (1-12), `day` (1-31), `hour` (0-23), `minute` (0-59), `second` (0-59). Optional: `latitude`, `longitude`, `city`, `country_code` (2-char ISO). Uses `checkdate()`.

**DateTimeLocation** (`validateDateTimeLocation`): same date/time fields + optional `latitude`, `longitude`, `timezone`.

**Allowed enums:**
- Sun signs: Aries..Pisces + 3-letter abbreviations (Ari, Tau, Gem...)
- Horoscope formats: paragraph, bullets, short, long
- Progression types: secondary, primary, tertiary, minor
- Direction types: solar_arc, symbolic, profection, naibod
- House systems: P, W, K, A, R, C, B, M, O, E, V, X, H, T, G

## Adding a New Endpoint — Full Checklist

1. Add method to existing client in `src/Categories/` (or create new client)
2. Add validation in `Validators.php` if needed (reuse existing validators)
3. Validate **before** the HTTP call, never after
4. Write unit test in `tests/Unit/Categories/` asserting correct URL path
5. Write integration test in `tests/Integration/Categories/` with real API call
6. Register new client in `AstrologyClient.php` if creating a new category
7. Run `composer lint:fix && composer test`

## Common Pitfalls

- **Integer arguments to `buildUrl()`**: accepts `string ...$segments` only. Cast integers: `(string) $year`
- **InsightsClient nesting**: `$client->insights->relationship->getCompatibility(...)` not `$client->insights->getCompatibility(...)`
- **SVG/PDF endpoints**: return non-JSON (SVG markup, PDF binary). Don't assume array response.
- **Guzzle constraints**: use `^7.5` not exact versions — this is a library
- **`docs` script**: defined in CLAUDE.md but requires `phpdocumentor/phpdocumentor` dev dependency
