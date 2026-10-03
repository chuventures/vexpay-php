<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * Invalid client configuration (e.g. a missing API key). Thrown before any request.
 */
class ConfigurationException extends VexPayException
{
}
