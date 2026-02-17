<?php

declare(strict_types=1);

namespace Procoders\AstrologyApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\Create as PromiseCreate;
use GuzzleHttp\Promise\PromiseInterface;
use Procoders\AstrologyApi\Categories\AnalysisClient;
use Procoders\AstrologyApi\Categories\AstrocartographyClient;
use Procoders\AstrologyApi\Categories\ChartsClient;
use Procoders\AstrologyApi\Categories\ChineseClient;
use Procoders\AstrologyApi\Categories\DataClient;
use Procoders\AstrologyApi\Categories\EclipsesClient;
use Procoders\AstrologyApi\Categories\EnhancedClient;
use Procoders\AstrologyApi\Categories\FixedStarsClient;
use Procoders\AstrologyApi\Categories\GlossaryClient;
use Procoders\AstrologyApi\Categories\HoroscopeClient;
use Procoders\AstrologyApi\Categories\InsightsClient;
use Procoders\AstrologyApi\Categories\LunarClient;
use Procoders\AstrologyApi\Categories\NumerologyClient;
use Procoders\AstrologyApi\Categories\SvgClient;
use Procoders\AstrologyApi\Categories\TarotClient;
use Procoders\AstrologyApi\Categories\FengshuiClient;
use Procoders\AstrologyApi\Categories\HealthClient;
use Procoders\AstrologyApi\Categories\HoraryClient;
use Procoders\AstrologyApi\Categories\HumanDesignClient;
use Procoders\AstrologyApi\Categories\KabbalahClient;
use Procoders\AstrologyApi\Categories\PalmistryClient;
use Procoders\AstrologyApi\Categories\PdfClient;
use Procoders\AstrologyApi\Categories\RenderClient;
use Procoders\AstrologyApi\Categories\TraditionalClient;
use Procoders\AstrologyApi\Categories\VedicClient;
use Procoders\AstrologyApi\Categories\ZiweiClient;
use Procoders\AstrologyApi\Config\AstrologyClientConfig;
use Procoders\AstrologyApi\Config\RetryConfig;
use Procoders\AstrologyApi\Utils\GuzzleHttpHelper;
use Procoders\AstrologyApi\Utils\HttpHelper;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Root client exposing each Astrology API category as dedicated sub-clients.
 */
final class AstrologyClient
{
    private readonly AstrologyClientConfig $config;
    private readonly ClientInterface $httpClient;
    private readonly HttpHelper $httpHelper;
    private readonly bool $debug;
    /** @var callable(string, array):void|null */
    private readonly mixed $logger;

    public readonly DataClient $data;
    public readonly ChartsClient $charts;
    public readonly HoroscopeClient $horoscope;
    public readonly AnalysisClient $analysis;
    public readonly GlossaryClient $glossary;
    public readonly AstrocartographyClient $astrocartography;
    public readonly ChineseClient $chinese;
    public readonly EclipsesClient $eclipses;
    public readonly LunarClient $lunar;
    public readonly NumerologyClient $numerology;
    public readonly TarotClient $tarot;
    public readonly TraditionalClient $traditional;
    public readonly FixedStarsClient $fixedStars;
    public readonly InsightsClient $insights;
    public readonly SvgClient $svg;
    public readonly EnhancedClient $enhanced;
    public readonly VedicClient $vedic;
    public readonly HumanDesignClient $humanDesign;
    public readonly KabbalahClient $kabbalah;
    public readonly HoraryClient $horary;
    public readonly FengshuiClient $fengshui;
    public readonly PalmistryClient $palmistry;
    public readonly PdfClient $pdf;
    public readonly RenderClient $render;
    public readonly ZiweiClient $ziwei;
    public readonly HealthClient $health;

    /**
     * @param array{
     *     apiKey?: string|null,
     *     baseUrl?: string|null,
     *     baseURL?: string|null,
     *     timeout?: int|null,
     *     retry?: array<string,mixed>|RetryConfig,
     *     debug?: bool|null,
     *     logger?: callable|null,
     *     guzzleOptions?: array<string,mixed>
     * }|AstrologyClientConfig $config
     */
    public function __construct(array|AstrologyClientConfig $config = [])
    {
        $this->config = $config instanceof AstrologyClientConfig ? $config : AstrologyClientConfig::fromArray($config);
        $this->debug = $this->config->debug;
        $this->logger = $this->config->logger;

        $this->httpClient = $this->createHttpClient();
        $this->httpHelper = new GuzzleHttpHelper($this->httpClient);

        $this->data = new DataClient($this->httpHelper);
        $this->charts = new ChartsClient($this->httpHelper);
        $this->horoscope = new HoroscopeClient($this->httpHelper);
        $this->analysis = new AnalysisClient($this->httpHelper);
        $this->glossary = new GlossaryClient($this->httpHelper);
        $this->astrocartography = new AstrocartographyClient($this->httpHelper);
        $this->chinese = new ChineseClient($this->httpHelper);
        $this->eclipses = new EclipsesClient($this->httpHelper);
        $this->lunar = new LunarClient($this->httpHelper);
        $this->numerology = new NumerologyClient($this->httpHelper);
        $this->tarot = new TarotClient($this->httpHelper);
        $this->traditional = new TraditionalClient($this->httpHelper);
        $this->fixedStars = new FixedStarsClient($this->httpHelper);
        $this->insights = new InsightsClient($this->httpHelper);
        $this->svg = new SvgClient($this->httpHelper);
        $this->enhanced = new EnhancedClient($this->httpHelper);
        $this->vedic = new VedicClient($this->httpHelper);
        $this->humanDesign = new HumanDesignClient($this->httpHelper);
        $this->kabbalah = new KabbalahClient($this->httpHelper);
        $this->horary = new HoraryClient($this->httpHelper);
        $this->fengshui = new FengshuiClient($this->httpHelper);
        $this->palmistry = new PalmistryClient($this->httpHelper);
        $this->pdf = new PdfClient($this->httpHelper);
        $this->render = new RenderClient($this->httpHelper);
        $this->ziwei = new ZiweiClient($this->httpHelper);
        $this->health = new HealthClient($this->httpHelper);
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    public function getHttpHelper(): HttpHelper
    {
        return $this->httpHelper;
    }

    private function createHttpClient(): ClientInterface
    {
        $options = $this->config->guzzleOptions;
        $baseHandler = null;
        if (isset($options['handler'])) {
            $baseHandler = $options['handler'];
            unset($options['handler']);
        }

        $handlerStack = HandlerStack::create($baseHandler);
        $handlerStack->push($this->createRetryMiddleware($this->config->retry));
        $handlerStack->push(Middleware::mapRequest($this->apiKeyInjector()));
        $handlerStack->push(Middleware::tap(\Closure::fromCallable([$this, 'logRequest']), \Closure::fromCallable([$this, 'logResponse'])));

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (isset($options['headers']) && is_array($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
        }

        $options['headers'] = $headers;
        $options['base_uri'] = $this->config->baseUrl;
        $options['timeout'] = $this->config->timeoutMs / 1000;
        $options['handler'] = $handlerStack;

        return new Client($options);
    }

    private function createRetryMiddleware(RetryConfig $retryConfig): callable
    {
        $decider = function (int $retries, RequestInterface $request, ?ResponseInterface $response, ?Throwable $exception) use ($retryConfig): bool {
            if ($retries >= $retryConfig->attempts) {
                return false;
            }

            if ($response instanceof ResponseInterface) {
                $shouldRetry = in_array($response->getStatusCode(), $retryConfig->statusCodes, true);
                if ($shouldRetry) {
                    $this->log('Retry triggered by status code', [
                        'url' => (string) $request->getUri(),
                        'status' => $response->getStatusCode(),
                        'attempt' => $retries + 1,
                    ]);
                }

                return $shouldRetry;
            }

            if ($exception instanceof ConnectException || $exception instanceof TransferException) {
                $this->log('Retry triggered by network error', [
                    'url' => (string) $request->getUri(),
                    'exception' => $exception->getMessage(),
                    'attempt' => $retries + 1,
                ]);

                return true;
            }

            return false;
        };

        $delay = static fn (int $retries): int => $retryConfig->delayMs;

        return Middleware::retry($decider, $delay);
    }

    private function apiKeyInjector(): callable
    {
        $apiKey = $this->config->apiKey;

        if ($apiKey === null) {
            return static fn (RequestInterface $request): RequestInterface => $request;
        }

        return static function (RequestInterface $request) use ($apiKey): RequestInterface {
            if ($request->hasHeader('X-API-Key')) {
                return $request;
            }

            return $request->withHeader('X-API-Key', $apiKey);
        };
    }

    private function logRequest(RequestInterface $request, array $options): void
    {
        $sanitized = null;
        if ($this->debug) {
            $sanitized = $options;
            unset($sanitized['headers']);
        }

        $this->log('Outgoing request', [
            'method' => $request->getMethod(),
            'url' => (string) $request->getUri(),
            'options' => $sanitized,
        ]);
    }

    private function logResponse(RequestInterface $request, array $options, PromiseInterface $response): void
    {
        $response->then(
            function (ResponseInterface $resolved) use ($request): ResponseInterface {
                $this->log('Response received', [
                    'url' => (string) $request->getUri(),
                    'status' => $resolved->getStatusCode(),
                ]);

                return $resolved;
            },
            function (mixed $reason) use ($request) {
                $message = $reason instanceof Throwable ? $reason->getMessage() : (string) $reason;
                $this->log('Request failed', [
                    'url' => (string) $request->getUri(),
                    'error' => $message,
                ]);

                return PromiseCreate::rejectionFor($reason);
            }
        );
    }

    private function log(string $message, ?array $context = null): void
    {
        if (!$this->debug || $this->logger === null) {
            return;
        }

        try {
            ($this->logger)('[AstrologyClient] ' . $message, $context ?? []);
        } catch (Throwable) {
            // Swallow logger exceptions.
        }
    }
}
