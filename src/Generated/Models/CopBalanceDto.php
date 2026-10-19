<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopBalanceDto extends Model
{
    public function __construct(
        /**
         * Whole pesos available for payout. Excludes `heldCop`.
         */
        public readonly float $availableCop,
        /**
         * Whole pesos reserved by payouts in progress.
         */
        public readonly float $pendingPayoutCop,
        public readonly string $asOf,
        /**
         * Whole pesos under the 24h balance hold: credited but not payable until the hold ends.
         */
        public readonly ?float $heldCop = null,
        /**
         * When the soonest held amount becomes available; null when nothing is held.
         */
        public readonly ?string $nextReleaseAt = null,
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
            heldCop: $data['heldCop'] ?? null,
            nextReleaseAt: $data['nextReleaseAt'] ?? null,
        ))->withRaw($data);
    }
}
