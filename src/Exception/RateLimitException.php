<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * 429. When isRateLimit() is true (VEX Pay's rate limiter: body `error` = `rate_limited` or a
 * `RateLimit` header), it was retried after `Retry-After` before surfacing. Otherwise it is a
 * risk decline (e.g. `CARD_VELOCITY_BLOCKED`) and was not retried.
 */
class RateLimitException extends VexPayException
{
    public function __construct(
        string $message,
        ?int $status = null,
        ?string $errorCode = null,
        mixed $body = null,
        ?string $requestId = null,
        ?\Throwable $previous = null,
        private readonly bool $rateLimit = false,
        private readonly ?float $retryAfterSeconds = null,
        private readonly ?string $rateLimitHeader = null,
        private readonly ?string $rateLimitPolicy = null,
    ) {
        parent::__construct($message, $status, $errorCode, $body, $requestId, $previous);
    }

    /** True when the API's rate limiter refused the request. */
    public function isRateLimit(): bool
    {
        return $this->rateLimit;
    }

    /** Seconds to wait, from the `Retry-After` header, when present. */
    public function getRetryAfterSeconds(): ?float
    {
        return $this->retryAfterSeconds;
    }

    /** Raw `RateLimit` header, e.g. `"write";r=0;t=2`. */
    public function getRateLimit(): ?string
    {
        return $this->rateLimitHeader;
    }

    /** Raw `RateLimit-Policy` header, e.g. `"write";q=50;w=2`. */
    public function getRateLimitPolicy(): ?string
    {
        return $this->rateLimitPolicy;
    }
}
