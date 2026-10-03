<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class BatchPayoutItemDto extends Model
{
    public function __construct(
        public readonly string $merchantId,
        public readonly string $monto,
        public readonly string $concepto,
        public readonly string $externalRef,
        /**
         * Payout method to credit. Defaults to the merchant’s default verified method when omitted.
         */
        public readonly ?string $payoutMethodId = null,
        /**
         * When true, debit the seller available balance instead of tenant float.
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
            fromMerchantBalance: $data['fromMerchantBalance'] ?? null,
        ))->withRaw($data);
    }
}
