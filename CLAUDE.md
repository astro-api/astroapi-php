# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

PHP 8.1+ SDK client for the Astrology API v3. Package: `procoders/astrology-api-php`. Uses Guzzle 7 for HTTP transport. This is a standalone library (no framework, no database).

## Common Commands

```bash
# Install dependencies
composer install

# Run tests
composer test                    # Full PHPUnit suite
vendor/bin/phpunit tests/Unit/Categories/ChartsClientTest.php  # Single test file
vendor/bin/phpunit --filter testMethodName  # Single test method

# Code coverage
composer coverage                # HTML report in coverage/ + text output

# Code style
composer lint                    # Check only (dry-run)
composer lint:fix                # Auto-fix violations

# Documentation
composer docs                    # Generate PHPDoc in docs/
```

## Architecture

**Root Client:** `AstrologyClient` is the entry point. It creates a Guzzle client with middleware (retry, API key injection, logging) and exposes 26 readonly category client properties.

**Category Clients:** Each in `src/Categories/`, extending `BaseCategoryClient`. Methods validate inputs via `Validators` then delegate HTTP calls through `HttpHelper`. The `InsightsClient` is special — it contains 5 nested sub-clients (relationship, pet, wellness, financial, business).

**HTTP Layer:** `HttpHelper` interface with `GuzzleHttpHelper` implementation. Responses are normalized by extracting `data` or `result` fields from JSON.

**Validation:** All in `Utils/Validators.php` with static methods. Validation runs before every HTTP call. Throws `AstrologyError` on failure.

**Error Handling:** Single exception type `AstrologyError` with factory methods `fromGuzzleException()` and `normalize()`. Exposes `statusCode`, `errorCode`, `details` plus `isClientError()`/`isServerError()` helpers.

**Configuration:** `AstrologyClientConfig` (readonly) accepts array or object. Reads env vars: `ASTROLOGY_API_KEY`, `ASTROLOGY_API_BASE_URL`, `ASTROLOGY_DEBUG`. Retry config: `RetryConfig` (readonly).

## Code Conventions

- Every file uses `declare(strict_types=1)`
- PSR-12 style enforced via PHP-CS-Fixer
- Classes are `final` unless inheritance is needed
- Heavy use of PHP 8.1+ `readonly` properties
- PSR-4 autoloading: `Procoders\AstrologyApi\` → `src/`, `Procoders\AstrologyApi\Tests\` → `tests/`

## Testing Patterns

**Unit tests** (`tests/Unit/`): Use `SpyHttpHelper` and Guzzle's `MockHandler` — no real HTTP calls. Tests cover URL construction, validation, retry behavior, and error normalization. Always run.

**Integration tests** (`tests/Integration/`): Make real HTTP requests to the API. Automatically skipped when `ASTROLOGY_API_KEY` env var is not set. Each category has a test file with 1-3 representative endpoint calls.

```bash
# Run only unit tests
composer test:unit

# Run only integration tests (requires API key)
ASTROLOGY_API_KEY=your_key composer test:integration

# Run both (integration tests skip without key)
composer test
```

PHPUnit 10 with random execution order and strict mode (fail on risky/warnings).

## Adding a New Endpoint

1. Add/update category client method in `src/Categories/` (extend `BaseCategoryClient`)
2. Add validation logic to `Utils/Validators.php` if needed
3. Call validation before the HTTP request in the method
4. Write tests in `tests/Unit/Categories/` using `MockHandler`
5. Run `composer lint:fix && composer test`
