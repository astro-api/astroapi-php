# Copilot Instructions for procoders/astrology-api-php

PHP 8.1+ SDK for the Astrology API v3. Guzzle 7 HTTP transport. Standalone library (no framework).

## Code Style

- `declare(strict_types=1)` in every file
- PSR-12 with single quotes, short array syntax `[]`, strict params
- All classes `final` unless they need inheritance
- PHP 8.1+ `readonly` properties for immutable state
- Namespace: `Procoders\AstrologyApi\` maps to `src/`

## Architecture

`AstrologyClient` is the entry point with 26 readonly category client properties (e.g. `$client->charts`, `$client->horoscope`). Each category client extends `BaseCategoryClient` which provides `buildUrl(string ...$segments)` for URL construction.

Data flow: validate inputs via `Validators::validate*()` → call `$this->http->post/get()` → `GuzzleHttpHelper` normalizes response (extracts `data` or `result` key from JSON).

Only exception type: `AstrologyError` (statusCode, errorCode, details, isClientError(), isServerError()).

## Category Client Method Pattern

```php
public function getBar(array $request, array $options = []): mixed
{
    Validators::validateSubject($request['subject'] ?? [], 'BarRequest.subject');
    return $this->http->post($this->buildUrl('bar'), $request, $options);
}
```

Rules:
- Return type is always `mixed`
- `$options` is always the last parameter
- Validate BEFORE HTTP call
- Validation context: `'ClassName.fieldName'`
- `buildUrl()` takes only strings — cast integers: `(string) $year`

## Test Pattern (Unit)

Use `SpyHttpHelper` — captures lastMethod, lastPath, lastPayload, lastQuery:
```php
$this->http = new SpyHttpHelper();
$this->client = new FooClient($this->http);
$this->client->getBar(['subject' => $this->subject()]);
self::assertSame('/api/v3/foo/bar', $this->http->lastPath);
```

## Test Pattern (Integration)

Extend `IntegrationTestCase` (auto-skips without `ASTROLOGY_API_KEY`):
```php
$response = self::$client->foo->getBar(['subject' => $this->subject()]);
$this->assertSuccessResponse($response);
```

## Validation Reference

Subject birth_data requires: year (1900-2100), month (1-12), day (1-31), hour (0-23), minute (0-59), second (0-59). Optional: latitude, longitude, city, country_code.

Enums: Sun signs (Aries..Pisces + 3-letter), horoscope formats (paragraph/bullets/short/long), progression types (secondary/primary/tertiary/minor), direction types (solar_arc/symbolic/profection/naibod), house systems (P/W/K/A/R/C/B/M/O/E/V/X/H/T/G).

## Important Notes

- `InsightsClient` has nested sub-clients: `$client->insights->relationship->getCompatibility(...)`
- SVG/PDF endpoints return non-JSON (raw strings) — don't assume array response
- Real API requires location data INSIDE `birth_data` (latitude, longitude, city, nation, timezone)
