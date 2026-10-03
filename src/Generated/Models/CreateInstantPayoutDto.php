<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateInstantPayoutDto extends Model
{
    public function __construct(
        /**
         * Gross two-decimal VES amount to withdraw from the tenant ledger. Credits the tenant’s verified payout account (net of feePercent). Requires a verified eligible account (cooling only after destination change).
         */
        public readonly string $monto,
        /**
         * Statement concept (max 30 chars).
         */
        public readonly string $concepto,
        /**
         * Required idempotency key per tenant. Same payload → 200 replay; conflicting payload → 409 external_ref_conflict.
         */
        public readonly string $externalRef,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            monto: self::required($data, 'monto'),
            concepto: self::required($data, 'concepto'),
            externalRef: self::required($data, 'externalRef'),
        ))->withRaw($data);
    }
}
