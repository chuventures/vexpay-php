<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * The request never got an HTTP answer (DNS, refused, reset).
 */
class ApiConnectionException extends VexPayException
{
}
