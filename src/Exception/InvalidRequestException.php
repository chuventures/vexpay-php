<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * 400, 403, 410, 422 and other non-retryable 4xx — fix the request before retrying.
 */
class InvalidRequestException extends VexPayException
{
}
