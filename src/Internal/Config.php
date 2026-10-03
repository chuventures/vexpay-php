<?php

declare(strict_types=1);

namespace VexPay\Internal;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use VexPay\Exception\ConfigurationException;

/**
 * @internal
 */
final class Config
{
    public const DEFAULT_BASE_URL = 'https://api.pay.vexwallet.co';
    public const DEFAULT_TIMEOUT = 30.0;
    public const DEFAULT_MAX_NETWORK_RETRIES = 2;

    private const KEYS = [
        'api_key',
        'base_url',
        'timeout',
        'max_network_retries',
        'http_client',
        'request_factory',
        'stream_factory',
    ];

    public readonly string $apiKey;
    public readonly string $baseUrl;
    public readonly float $timeout;
    public readonly int $maxNetworkRetries;
    public readonly ClientInterface $httpClient;
    public readonly RequestFactoryInterface $requestFactory;
    public readonly StreamFactoryInterface $streamFactory;

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options)
    {
        $unknown = array_diff(array_keys($options), self::KEYS);
        if ($unknown !== []) {
            throw new ConfigurationException(sprintf(
                'Unknown VexPayClient option(s): %s. Supported: %s.',
                implode(', ', $unknown),
                implode(', ', self::KEYS),
            ));
        }

        $apiKey = $options['api_key'] ?? null;
        if (!is_string($apiKey) || trim($apiKey) === '') {
            throw new ConfigurationException(
                "A VEXPay API key is required: new VexPayClient(getenv('VEXPAY_API_KEY'))."
            );
        }
        $this->apiKey = trim($apiKey);

        $baseUrl = $options['base_url'] ?? null;
        $this->baseUrl = rtrim(is_string($baseUrl) && $baseUrl !== '' ? $baseUrl : self::DEFAULT_BASE_URL, '/');

        $timeout = $options['timeout'] ?? self::DEFAULT_TIMEOUT;
        if (!is_int($timeout) && !is_float($timeout) || $timeout <= 0) {
            throw new ConfigurationException('The "timeout" option must be a positive number of seconds.');
        }
        $this->timeout = (float) $timeout;

        $retries = $options['max_network_retries'] ?? self::DEFAULT_MAX_NETWORK_RETRIES;
        if (!is_int($retries) || $retries < 0) {
            throw new ConfigurationException('The "max_network_retries" option must be an integer >= 0.');
        }
        $this->maxNetworkRetries = $retries;

        $factory = null;
        $this->httpClient = self::instance($options, 'http_client', ClientInterface::class)
            ?? new GuzzleClient(['http_errors' => false]);
        $this->requestFactory = self::instance($options, 'request_factory', RequestFactoryInterface::class)
            ?? ($factory ??= new HttpFactory());
        $this->streamFactory = self::instance($options, 'stream_factory', StreamFactoryInterface::class)
            ?? ($factory ??= new HttpFactory());
    }

    /**
     * @template T of object
     *
     * @param array<string, mixed> $options
     * @param class-string<T> $interface
     *
     * @return T|null
     */
    private static function instance(array $options, string $key, string $interface): ?object
    {
        $value = $options[$key] ?? null;
        if ($value === null) {
            return null;
        }
        if (!$value instanceof $interface) {
            throw new ConfigurationException(sprintf('The "%s" option must implement %s.', $key, $interface));
        }

        return $value;
    }
}
