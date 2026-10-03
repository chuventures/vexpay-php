<?php

declare(strict_types=1);

namespace VexPay\Internal;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ConnectTimeoutException;
use GuzzleHttp\Exception\NetworkTimeoutException;
use GuzzleHttp\Exception\ResponseTimeoutException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use VexPay\Exception\ApiConnectionException;
use VexPay\Exception\ApiTimeoutException;
use VexPay\Exception\ConfigurationException;
use VexPay\Exception\InvalidRequestException;
use VexPay\Exception\VexPayException;
use VexPay\Version;

/**
 * Sends one API call: builds the request, retries safe failures with one Idempotency-Key,
 * and maps error responses to typed exceptions.
 *
 * @internal
 */
final class Requester
{
    private const OPTION_KEYS = ['idempotency_key', 'timeout', 'max_network_retries'];
    private const CURLE_OPERATION_TIMEDOUT = 28;

    /** @var \Closure(float): void */
    private readonly \Closure $sleep;

    /** @var \Closure(): float */
    private readonly \Closure $random;

    /**
     * @param (\Closure(float): void)|null $sleep seconds
     * @param (\Closure(): float)|null $random float in [0, 1)
     */
    public function __construct(
        public readonly Config $config,
        ?\Closure $sleep = null,
        ?\Closure $random = null,
    ) {
        $this->sleep = $sleep ?? static function (float $seconds): void {
            usleep((int) round($seconds * 1_000_000));
        };
        $this->random = $random ?? static fn (): float => mt_rand() / (mt_getrandmax() + 1);
    }

    public static function userAgent(): string
    {
        return sprintf('vexpay-php/%s php/%s', Version::VERSION, PHP_VERSION);
    }

    /**
     * @param array<string, scalar|null> $query
     * @param array{idempotency_key?: string, timeout?: int|float, max_network_retries?: int} $options
     */
    public function request(string $method, string $path, array $query = [], mixed $body = null, array $options = []): mixed
    {
        $unknown = array_diff(array_keys($options), self::OPTION_KEYS);
        if ($unknown !== []) {
            throw new ConfigurationException(sprintf(
                'Unknown request option(s): %s. Supported: %s.',
                implode(', ', $unknown),
                implode(', ', self::OPTION_KEYS),
            ));
        }
        $timeout = (float) ($options['timeout'] ?? $this->config->timeout);
        $maxRetries = (int) ($options['max_network_retries'] ?? $this->config->maxNetworkRetries);
        $request = $this->build($method, $path, $query, $body, $options['idempotency_key'] ?? null);

        $attempt = 0;
        while (true) {
            $retryAfter = null;
            try {
                $response = $this->send($request, $timeout);
                [$result, $error, $retryAfter] = $this->result($response);
                if ($error === null) {
                    return $result;
                }
            } catch (ApiConnectionException $connectionError) {
                $error = $connectionError;
            }
            if ($attempt >= $maxRetries || !RetryPolicy::isRetryable($error)) {
                throw $error;
            }
            ($this->sleep)($retryAfter ?? RetryPolicy::backoff($attempt, $this->random));
            ++$attempt;
        }
    }

    /**
     * @param array<string, string> $params
     */
    public static function fillPath(string $template, array $params): string
    {
        return (string) preg_replace_callback('/\{([^}]+)\}/', static function (array $match) use ($params): string {
            $value = $params[$match[1]] ?? null;
            if (!is_string($value) || $value === '') {
                throw new InvalidRequestException(sprintf('Missing required path parameter "%s".', $match[1]));
            }

            return rawurlencode($value);
        }, $template);
    }

    public static function uuid4(): string
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0F) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3F) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    /**
     * @param array<string, scalar|null> $query
     */
    private function build(string $method, string $path, array $query, mixed $body, ?string $idempotencyKey): RequestInterface
    {
        $url = $this->config->baseUrl . $path;
        $params = [];
        foreach ($query as $key => $value) {
            if ($value === null) {
                continue;
            }
            $params[$key] = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
        }
        if ($params !== []) {
            $url .= '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        }

        $request = $this->config->requestFactory->createRequest($method, $url)
            ->withHeader('Accept', 'application/json')
            ->withHeader('x-api-key', $this->config->apiKey)
            ->withHeader('User-Agent', self::userAgent());

        if ($body !== null) {
            $request = $request
                ->withHeader('Content-Type', 'application/json')
                ->withBody($this->config->streamFactory->createStream(self::encode($body)));
        }
        // One key for every attempt of this call: a retried POST can never charge twice.
        if ($method === 'POST') {
            $request = $request->withHeader('Idempotency-Key', $idempotencyKey ?? self::uuid4());
        }

        return $request;
    }

    private static function encode(mixed $body): string
    {
        // Request bodies are JSON objects; an empty PHP array must go out as {} rather than [].
        if ($body === []) {
            return '{}';
        }

        return json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR);
    }

    private function send(RequestInterface $request, float $timeout): ResponseInterface
    {
        $client = $this->config->httpClient;
        try {
            if ($client instanceof GuzzleClientInterface) {
                return $client->send($request, ['timeout' => $timeout, 'http_errors' => false]);
            }

            return $client->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            if (self::isTimeout($exception)) {
                throw new ApiTimeoutException(
                    sprintf('Request to VEXPay timed out after %ss', $timeout),
                    previous: $exception,
                );
            }

            throw new ApiConnectionException('Could not reach VEXPay: ' . $exception->getMessage(), previous: $exception);
        }
    }

    // Guzzle 8 throws dedicated timeout exceptions; Guzzle 7 only exposes cURL's errno.
    private static function isTimeout(ClientExceptionInterface $exception): bool
    {
        if ($exception instanceof ConnectTimeoutException
            || $exception instanceof NetworkTimeoutException
            || $exception instanceof ResponseTimeoutException) {
            return true;
        }

        return $exception instanceof ConnectException
            && method_exists($exception, 'getHandlerContext')
            && ($exception->getHandlerContext()['errno'] ?? null) === self::CURLE_OPERATION_TIMEDOUT;
    }

    /**
     * @return array{0: mixed, 1: ?VexPayException, 2: ?float}
     */
    private function result(ResponseInterface $response): array
    {
        $status = $response->getStatusCode();
        $body = self::decode((string) $response->getBody());
        if ($status >= 200 && $status < 300) {
            return [$body, null, null];
        }
        $requestId = $response->getHeaderLine('x-request-id');
        $error = ErrorFactory::fromResponse($status, $body, $requestId !== '' ? $requestId : null);

        return [null, $error, RetryPolicy::parseRetryAfter($response->getHeaderLine('retry-after') ?: null)];
    }

    private static function decode(string $content): mixed
    {
        if ($content === '') {
            return null;
        }
        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return $content;
        }
    }
}
