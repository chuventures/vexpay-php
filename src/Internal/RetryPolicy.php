<?php

declare(strict_types=1);

namespace VexPay\Internal;

use VexPay\Exception\ApiConnectionException;
use VexPay\Exception\VexPayException;

/**
 * @internal
 */
final class RetryPolicy
{
    private const INITIAL_DELAY = 0.5;
    private const MAX_DELAY = 8.0;
    private const MAX_RETRY_AFTER = 60.0;

    public static function isRetryable(VexPayException $error): bool
    {
        if ($error instanceof ApiConnectionException) {
            return true;
        }
        $status = $error->getStatus();
        if ($status === 429 || ($status !== null && $status >= 500)) {
            return true;
        }

        return $status === 409 && $error->getErrorCode() === 'idempotency_request_in_progress';
    }

    /**
     * Exponential backoff with jitter: attempt 0 → [0.25, 0.5) s, doubling, capped at 8 s.
     *
     * @param \Closure(): float $random returns a float in [0, 1)
     */
    public static function backoff(int $attempt, \Closure $random): float
    {
        $ceiling = min(self::INITIAL_DELAY * 2 ** $attempt, self::MAX_DELAY);

        return $ceiling / 2 + $random() * ($ceiling / 2);
    }

    /**
     * `Retry-After` as seconds or an HTTP date → seconds, capped at 60.
     */
    public static function parseRetryAfter(?string $value, ?int $now = null): ?float
    {
        if ($value === null || trim($value) === '') {
            return null;
        }
        $value = trim($value);
        if (is_numeric($value)) {
            $seconds = (float) $value;

            return $seconds >= 0 ? min($seconds, self::MAX_RETRY_AFTER) : null;
        }
        $when = strtotime($value);
        if ($when === false) {
            return null;
        }

        return min(max(0.0, (float) ($when - ($now ?? time()))), self::MAX_RETRY_AFTER);
    }
}
