<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * A webhook signature did not verify (see Webhook::constructEvent()).
 */
class SignatureVerificationException extends VexPayException
{
}
