<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateMerchantTransferDto extends Model
{
    public function __construct(
        /**
         * Idempotency key for this transfer under the merchant.
         */
        public readonly string $transferKey,
        /**
         * Exact two-decimal VES amount to move from platform float → seller pending. Send this or `amountUsd`, not both.
         */
        public readonly ?string $amountVes = null,
        /**
         * Exact two-decimal USD amount, converted to VES at the official BCV rate at the time of the request (regardless of your account’s Bolívar rate setting). The rate is saved with the transfer and a replay returns it. Send this or `amountVes`, not both.
         */
        public readonly ?string $amountUsd = null,
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
            transferKey: self::required($data, 'transferKey'),
            amountVes: $data['amountVes'] ?? null,
            amountUsd: $data['amountUsd'] ?? null,
            paymentId: $data['paymentId'] ?? null,
        ))->withRaw($data);
    }
}
