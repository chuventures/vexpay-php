<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * 429 — too many requests. Retried automatically before surfacing.
 */
class RateLimitException extends VexPayException
{
}
