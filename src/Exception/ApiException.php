<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * 5xx — VEX Pay or an upstream bank failed. Retried automatically before surfacing.
 */
class ApiException extends VexPayException
{
}
