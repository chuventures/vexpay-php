<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class SplitShareDto extends Model
{
    public function __construct(
        /**
         * A merchant of your account (UUID or `mrc_…` id). Each merchant at most once per payment.
         */
        public readonly string $merchantId,
        /**
         * This merchant's share, in the currency of the request's amount: VES for débito, C2P and Pago Móvil; for VPOS, VES when you send `vesAmount`, else USD. A string with exactly two decimals ("6000.00") or a number with at most two. USD shares are converted at the payment's rate and rounded down to Bs 0.01. Whatever the shares do not cover stays with your account (the marketplace remainder).
         */
        public readonly string|float $amount,
        /**
         * Your commission on this share, in VES (exactly two decimals). Not with applicationFeePercent.
         */
        public readonly ?string $applicationFeeVes = null,
        /**
         * Your commission as a percent of this share's VES amount. When both are omitted the merchant's negotiated commission applies, else your default commission, else none.
         */
        public readonly ?float $applicationFeePercent = null,
        /**
         * Free text returned as sent.
         */
        public readonly ?string $reference = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            merchantId: self::required($data, 'merchantId'),
            amount: self::required($data, 'amount'),
            applicationFeeVes: $data['applicationFeeVes'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
            reference: $data['reference'] ?? null,
        ))->withRaw($data);
    }
}
