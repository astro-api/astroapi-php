# Astrology API PHP SDK

[![CI](https://github.com/astro-api/astroapi-php/actions/workflows/ci.yml/badge.svg)](https://github.com/astro-api/astroapi-php/actions/workflows/ci.yml)
[![Latest Stable Version](https://poser.pugx.org/procoders/astrology-api-php/v)](https://packagist.org/packages/procoders/astrology-api-php)
[![License](https://poser.pugx.org/procoders/astrology-api-php/license)](https://packagist.org/packages/procoders/astrology-api-php)
[![PHP Version](https://poser.pugx.org/procoders/astrology-api-php/require/php)](https://packagist.org/packages/procoders/astrology-api-php)

PHP 8.1+ client for the [Astrology API v3](https://docs.astroapi.com) that mirrors the feature set of the official TypeScript SDK.
The package organises every API area as a dedicated category client and provides batteries-included tooling for validation, retries, logging, and testing.

---

## Installation

```bash
composer require procoders/astrology-api-php
```

Requires **PHP 8.1+** and Guzzle 7.x.

---

## Quick Start

```php
use Procoders\AstrologyApi\AstrologyClient;

$client = new AstrologyClient([
    'apiKey' => getenv('ASTROLOGY_API_KEY'),
]);

// Natal chart
$natal = $client->charts->getNatalChart([
    'subject' => [
        'name' => 'Ada Lovelace',
        'birth_data' => [
            'year' => 1815, 'month' => 12, 'day' => 10,
            'hour' => 7, 'minute' => 0, 'second' => 0,
            'latitude' => 51.5074, 'longitude' => -0.1278,
            'city' => 'London', 'nation' => 'GB',
            'timezone' => 'Europe/London',
        ],
    ],
]);

// Daily horoscope
$daily = $client->horoscope->getSignDailyHoroscope('Aries');

// Health check
$status = $client->health->check();
```

Every request is validated before dispatch. Invalid payloads throw `AstrologyError` with detailed field information.

---

## Configuration

```php
$client = new AstrologyClient([
    'apiKey'        => 'your-api-key',          // or ASTROLOGY_API_KEY env var
    'baseUrl'       => 'https://api.astroapi.com', // or ASTROLOGY_API_BASE_URL env var
    'timeout'       => 10000,                   // ms (default)
    'debug'         => false,                   // or ASTROLOGY_DEBUG env var
    'logger'        => function (string $msg, array $ctx) { error_log($msg); },
    'retry'         => [
        'attempts'    => 3,
        'delayMs'     => 250,
        'statusCodes' => [408, 425, 429, 500, 502, 503, 504],
    ],
    'guzzleOptions' => [],                      // forwarded to GuzzleHttp\Client
]);
```

---

## Category Clients

| Property | Endpoint Prefix | Description |
|----------|----------------|-------------|
| `health` | `/api/v3/health` | API health check and diagnostics |
| `data` | `/api/v3/data` | Planetary positions, aspects, current moment |
| `charts` | `/api/v3/charts` | Natal, synastry, transit, composite, solar return |
| `horoscope` | `/api/v3/horoscope` | Daily/weekly/monthly sign and personal horoscopes |
| `analysis` | `/api/v3/analysis` | Natal reports, compatibility, directions |
| `glossary` | `/api/v3/glossary` | Countries, elements, languages, house systems |
| `astrocartography` | `/api/v3/astrocartography` | Lines, maps, relocation |
| `chinese` | `/api/v3/chinese` | Ba Zi, zodiac animals, element analysis |
| `eclipses` | `/api/v3/eclipses` | Upcoming eclipses, natal impact |
| `lunar` | `/api/v3/lunar` | Phases, events, mansions, calendars |
| `numerology` | `/api/v3/numerology` | Core numbers, compatibility |
| `tarot` | `/api/v3/tarot` | Cards, spreads, daily card, analysis |
| `traditional` | `/api/v3/traditional` | Dignities, lots, profections |
| `fixedStars` | `/api/v3/fixed-stars` | Positions, conjunctions, presets |
| `insights` | `/api/v3/insights/**` | Relationship, pet, wellness, financial, business |
| `svg` | `/api/v3/svg` | SVG chart rendering |
| `enhanced` | `/api/v3/enhanced` | Enhanced personal analysis |
| `vedic` | `/api/v3/vedic` | Vedic charts, birth details, doshas |
| `humanDesign` | `/api/v3/human-design` | Bodygraph, types, gates, channels |
| `kabbalah` | `/api/v3/kabbalah` | Birth angels, Sephiroth, 72 angels |
| `horary` | `/api/v3/horary` | Horary astrology charts |
| `fengshui` | `/api/v3/fengshui` | Annual afflictions, flying stars |
| `palmistry` | `/api/v3/palmistry` | Palm reading from images |
| `pdf` | `/api/v3/pdf` | PDF report generation |
| `render` | `/api/v3/render` | Chart image rendering |
| `ziwei` | `/api/v3/ziwei` | Zi Wei Dou Shu charts |

---

## Error Handling

```php
use Procoders\AstrologyApi\Exceptions\AstrologyError;

try {
    $chart = $client->charts->getNatalChart([...]);
} catch (AstrologyError $e) {
    $e->getMessage();     // Human-friendly message
    $e->statusCode;       // HTTP status code
    $e->errorCode;        // API error code
    $e->details;          // Full decoded response body
    $e->isClientError();  // 4xx
    $e->isServerError();  // 5xx
}
```

---

## Testing

```bash
# All tests (integration tests auto-skip without API key)
composer test

# Unit tests only (mocked, always pass)
composer test:unit

# Integration tests (real API calls)
ASTROLOGY_API_KEY=your_key composer test:integration

# Code style
composer lint          # check
composer lint:fix      # auto-fix

# Coverage (requires Xdebug or PCOV)
composer coverage
```

---

## Contributing

1. Fork the repository
2. `composer install`
3. Make your changes
4. Ensure `composer lint` and `composer test` pass
5. Open a pull request

---

## Releasing

The project uses [Semantic Versioning](https://semver.org/): `MAJOR.MINOR.PATCH`.

- **MAJOR** — breaking changes to the public API (removed methods, changed signatures, renamed clients)
- **MINOR** — new features that are backward-compatible (new endpoints, new category clients)
- **PATCH** — backward-compatible bug fixes

### Pre-release checklist

```bash
# 1. Make sure you're on main with the latest code
git checkout main && git pull

# 2. Run the full check suite
composer lint
composer test:unit
ASTROLOGY_API_KEY=your_key composer test:integration

# 3. Verify there are no uncommitted changes
git status
```

### Creating a release

```bash
# 1. Create an annotated tag
git tag -a v1.2.0 -m "v1.2.0"

# 2. Push the tag
git push origin v1.2.0
```

Then go to **[GitHub Releases](https://github.com/astro-api/astroapi-php/releases/new)**:

1. Select the tag you just pushed
2. Set the title to `v1.2.0`
3. Describe the changes (new endpoints, fixes, breaking changes)
4. Click **Publish release**

### What happens automatically

When a release is published, the [release.yml](.github/workflows/release.yml) workflow:

1. **Notifies Packagist** — the new version becomes available via `composer require`
2. **Runs the full test suite** (unit + integration) as a post-release verification

No manual steps are needed after publishing the release.

### Versioning examples

| Change | Version bump | Example |
|--------|-------------|---------|
| Add a new endpoint to an existing client | MINOR | `1.0.0` → `1.1.0` |
| Add a new category client | MINOR | `1.1.0` → `1.2.0` |
| Fix a bug in validation or URL construction | PATCH | `1.2.0` → `1.2.1` |
| Rename a client property or method | MAJOR | `1.2.1` → `2.0.0` |
| Change minimum PHP version | MAJOR | `2.0.0` → `3.0.0` |

---

## License

[MIT](LICENSE)
