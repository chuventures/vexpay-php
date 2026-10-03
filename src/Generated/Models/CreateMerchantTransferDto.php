<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateMerchantTransferDto extends Model
{
    public function __construct(
        /**
         * Exact two-decimal VES amount to move from platform float → seller pending.
         */
        public readonly string $amountVes,
        /**
         * Idempotency key for this transfer under the merchant.
         */
        public readonly string $transferKey,
        /**
         * Optional funding payment correlation (does not enforce remaining-net).
         */
        public readonly ?string $paymentId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amountVes: self::required($data, 'amountVes'),
            transferKey: self::required($data, 'transferKey'),
            paymentId: $data['paymentId'] ?? null,
        ))->withRaw($data);
    }
}
