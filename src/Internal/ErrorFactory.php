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
    private const MACHINE_CODE = '/^[a-z][a-z0-9_]*$/';

    public static function fromResponse(int $status, mixed $body, ?string $requestId = null): VexPayException
    {
        $raw = is_array($body) ? ($body['error'] ?? null) : null;
        $code = is_string($raw) && preg_match(self::MACHINE_CODE, $raw) === 1 ? $raw : null;
        $message = self::message($body, $status);

        $class = match (true) {
            $status === 401 => AuthenticationException::class,
            $status === 404 => NotFoundException::class,
            $status === 409 => ConflictException::class,
            $status === 429 => RateLimitException::class,
            $status >= 500 => ApiException::class,
            default => InvalidRequestException::class,
        };

        return new $class($message, $status, $code, $body, $requestId);
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

        return sprintf('VEXPay API responded with HTTP %d', $status);
    }
}
