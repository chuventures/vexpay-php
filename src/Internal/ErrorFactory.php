<?php

declare(strict_types=1);

namespace VexPay\Internal;

use VexPay\Exception\ApiException;
use VexPay\Exception\AuthenticationException;
use VexPay\Exception\ConflictException;
use VexPay\Exception\InvalidRequestException;
use VexPay\Exception\NotFoundException;
use VexPay\Exception\RateLimitException;
use VexPay\Exception\VexPayException;

/**
 * @internal
 */
final class ErrorFactory
{
    /** Legacy `error` values that are codes (not HTTP reason phrases such as `Bad Request`). */
    private const MACHINE_CODE = '/^[a-z][a-z0-9_]*$/';

    /** `code` is stable: lowercase snake_case, or an uppercase risk or bank code (`PAYER_BLOCKED`, `AM04`). */
    private const API_CODE = '/^[A-Za-z0-9][A-Za-z0-9_]*$/';

    /**
     * @param array<string, string> $headers lower-case header names (only `ratelimit`,
     *                                       `ratelimit-policy` and `retry-after` are read)
     */
    public static function fromResponse(int $status, mixed $body, ?string $requestId = null, array $headers = []): VexPayException
    {
        $code = self::code($body);
        $docUrl = is_array($body) && is_string($body['docUrl'] ?? null) && $body['docUrl'] !== '' ? $body['docUrl'] : null;
        $message = self::message($body, $status);

        if ($status === 429) {
            $rateLimit = ($headers['ratelimit'] ?? '') !== '' ? $headers['ratelimit'] : null;
            $retryAfter = $headers['retry-after'] ?? null;
            $policy = ($headers['ratelimit-policy'] ?? '') !== '' ? $headers['ratelimit-policy'] : null;

            return new RateLimitException(
                $message,
                $status,
                $code,
                $body,
                $requestId,
                null,
                $rateLimit !== null || $code === 'rate_limited' || (is_array($body) && ($body['error'] ?? null) === 'rate_limited'),
                is_numeric($retryAfter) && (float) $retryAfter >= 0 ? (float) $retryAfter : null,
                $rateLimit,
                $policy,
                $docUrl,
            );
        }

        $class = match (true) {
            $status === 401 => AuthenticationException::class,
            $status === 404 => NotFoundException::class,
            $status === 409 => ConflictException::class,
            $status >= 500 => ApiException::class,
            default => InvalidRequestException::class,
        };

        return new $class($message, $status, $code, $body, $requestId, null, $docUrl);
    }

    /**
     * The body's `code` first, then a machine-readable `error` (APIs before `code` existed).
     */
    private static function code(mixed $body): ?string
    {
        if (!is_array($body)) {
            return null;
        }
        $code = $body['code'] ?? null;
        if (is_string($code) && preg_match(self::API_CODE, $code) === 1) {
            return $code;
        }
        $error = $body['error'] ?? null;

        return is_string($error) && preg_match(self::MACHINE_CODE, $error) === 1 ? $error : null;
    }

    private static function message(mixed $body, int $status): string
    {
        if (is_array($body)) {
            $message = $body['message'] ?? null;
            if (is_array($message)) {
                return implode('; ', array_map(static fn ($part) => (string) $part, $message));
            }
            if (is_string($message) && $message !== '') {
                return $message;
            }
            $error = $body['error'] ?? null;
            if (is_string($error) && $error !== '') {
                return $error;
            }
        }
        if (is_string($body) && $body !== '') {
            return $body;
        }

        return sprintf('VEX Pay API responded with HTTP %d', $status);
    }
}
