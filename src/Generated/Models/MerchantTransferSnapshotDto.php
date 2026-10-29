<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantTransferSnapshotDto extends Model
{
    public function __construct(
        public readonly string $transferKey,
        /**
         * VES credited to the merchant.
         */
        public readonly string $amountVes,
        /**
         * USD transfers only: the USD amount requested.
         */
        public readonly ?string $amountUsd = null,
        /**
         * USD transfers only: the BCV rate used.
         */
        public readonly ?string $rate = null,
        /**
         * USD transfers only: always `bcv`.
         */
        public readonly ?string $rateSource = null,
        /**
         * USD transfers only: when the rate was read.
         */
        public readonly ?string $rateAsOf = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            transferKey: self::required($data, 'transferKey'),
            amountVes: self::required($data, 'amountVes'),
            amountUsd: $data['amountUsd'] ?? null,
            rate: $data['rate'] ?? null,
            rateSource: $data['rateSource'] ?? null,
            rateAsOf: $data['rateAsOf'] ?? null,
        ))->withRaw($data);
    }
}
