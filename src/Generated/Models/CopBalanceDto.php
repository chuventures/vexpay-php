<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopBalanceDto extends Model
{
    public function __construct(
        /**
         * Whole pesos available for payout.
         */
        public readonly float $availableCop,
        /**
         * Whole pesos reserved by payouts in progress.
         */
        public readonly float $pendingPayoutCop,
        public readonly string $asOf,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            availableCop: self::required($data, 'availableCop'),
            pendingPayoutCop: self::required($data, 'pendingPayoutCop'),
            asOf: self::required($data, 'asOf'),
        ))->withRaw($data);
    }
}
