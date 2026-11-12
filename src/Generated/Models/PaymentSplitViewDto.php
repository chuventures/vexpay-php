<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentSplitViewDto extends Model
{
    public function __construct(
        public readonly string $merchantId,
        /**
         * The merchant's account id (same as the payment-level accountId).
         */
        public readonly string $accountId,
        public readonly string $amountVes,
        /**
         * Your commission on this share.
         */
        public readonly string $applicationFeeVes,
        /**
         * The merchant's externalRef.
         */
        public readonly ?string $merchantExternalRef = null,
        public readonly ?string $applicationFeePercent = null,
        /**
         * This share's part of the VEX Pay fee (null until completed).
         */
        public readonly ?string $feeVes = null,
        /**
         * Credited to the merchant (null until completed; 0.00 when the share nets nothing).
         */
        public readonly ?string $netVes = null,
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
            accountId: self::required($data, 'accountId'),
            amountVes: self::required($data, 'amountVes'),
            applicationFeeVes: self::required($data, 'applicationFeeVes'),
            merchantExternalRef: $data['merchantExternalRef'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
            feeVes: $data['feeVes'] ?? null,
            netVes: $data['netVes'] ?? null,
            reference: $data['reference'] ?? null,
        ))->withRaw($data);
    }
}
