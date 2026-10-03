<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreatePayoutDto extends Model
{
    public function __construct(
        /**
         * Verified, active merchant that receives the payout.
         */
        public readonly string $merchantId,
        /**
         * Exact two-decimal VES amount as a string. The gateway never converts FX for payouts.
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
        /**
         * Payout method to credit. Defaults to the merchant’s default verified method when omitted.
         */
        public readonly ?string $payoutMethodId = null,
        /**
         * Optional funding payment for marketplace settlement. When set, montos are capped by remaining net (vesAmount − feeVes − PENDING/COMPLETED payouts). Multiple payouts allowed until remaining is 0.
         */
        public readonly ?string $paymentId = null,
        /**
         * When true, debit the seller available balance (tenant float already reserved via SELLER_TRANSFER). Default false = classic tenant-float payout.
         */
        public readonly ?bool $fromMerchantBalance = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            merchantId: self::required($data, 'merchantId'),
            monto: self::required($data, 'monto'),
            concepto: self::required($data, 'concepto'),
            externalRef: self::required($data, 'externalRef'),
            payoutMethodId: $data['payoutMethodId'] ?? null,
            paymentId: $data['paymentId'] ?? null,
            fromMerchantBalance: $data['fromMerchantBalance'] ?? null,
        ))->withRaw($data);
    }
}
