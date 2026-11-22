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
    public const DEFAULT_BASE_URL = 'https://api.vexpay.app';
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
        'app_info',
    ];

    private const APP_NAME_PATTERN = '/^[a-z0-9][a-z0-9._-]{0,39}$/';
    private const APP_VERSION_PATTERN = '/^[0-9A-Za-z.+-]{1,32}$/';

    public readonly string $apiKey;
    public readonly string $baseUrl;
    public readonly float $timeout;
    public readonly int $maxNetworkRetries;
    public readonly ClientInterface $httpClient;
    public readonly RequestFactoryInterface $requestFactory;
    public readonly StreamFactoryInterface $streamFactory;

    /**
     * Integration built on the SDK, sent in the VexPay-Client header and the User-Agent.
     *
     * @var array{name: string, version?: string}|null
     */
    public readonly ?array $appInfo;

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
                "A VEX Pay API key is required: new VexPayClient(getenv('VEXPAY_API_KEY'))."
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

        $this->appInfo = self::appInfo($options['app_info'] ?? null);

        $factory = null;
        $this->httpClient = self::instance($options, 'http_client', ClientInterface::class)
            ?? new GuzzleClient(['http_errors' => false]);
        $this->requestFactory = self::instance($options, 'request_factory', RequestFactoryInterface::class)
            ?? ($factory ??= new HttpFactory());
        $this->streamFactory = self::instance($options, 'stream_factory', StreamFactoryInterface::class)
            ?? ($factory ??= new HttpFactory());
    }

    /**
     * @return array{name: string, version?: string}|null
     */
    private static function appInfo(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }
        $name = is_array($value) ? ($value['name'] ?? null) : null;
        if (!is_string($name) || preg_match(self::APP_NAME_PATTERN, $name) !== 1) {
            throw new ConfigurationException(
                'The "app_info" option needs a "name" of 1-40 lowercase letters, digits, ".", "_" or "-", '
                . 'starting with a letter or digit.'
            );
        }
        $version = $value['version'] ?? null;
        if ($version === null) {
            return ['name' => $name];
        }
        if (!is_string($version) || preg_match(self::APP_VERSION_PATTERN, $version) !== 1) {
            throw new ConfigurationException(
                'The "app_info" "version" must be 1-32 characters of 0-9, A-Z, a-z, ".", "+" or "-".'
            );
        }

        return ['name' => $name, 'version' => $version];
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
