<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * 409 — e.g. `external_ref_conflict`, `idempotency_key_reused`.
 */
class ConflictException extends VexPayException
{
}
