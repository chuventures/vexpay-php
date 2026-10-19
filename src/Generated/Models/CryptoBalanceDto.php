<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CryptoBalanceDto extends Model
{
    public function __construct(
        public readonly CryptoBalanceDtoCurrency|string $currency,
        /**
         * Available for payouts, in `currency` (ledger). Excludes `held`.
         */
        public readonly string $available,
        /**
         * Reserved by payouts that have not completed yet, in `currency`.
         */
        public readonly string $pendingPayout,
        public readonly string $asOf,
        /**
         * Under the 24h balance hold: credited but not payable until its hold ends, in `currency`.
         */
        public readonly ?string $held = null,
        /**
         * When the soonest held amount becomes available; null when nothing is held.
         */
        public readonly ?string $nextReleaseAt = null,
        /**
         * USDT only: same as `available`.
         */
        public readonly ?string $availableUsdt = null,
        /**
         * USDT only: same as `pendingPayout`.
         */
        public readonly ?string $pendingPayoutUsdt = null,
        /**
         * USDT only: same as `held`.
         */
        public readonly ?string $heldUsdt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            currency: self::enumOrRaw(CryptoBalanceDtoCurrency::class, self::required($data, 'currency')),
            available: self::required($data, 'available'),
            pendingPayout: self::required($data, 'pendingPayout'),
            asOf: self::required($data, 'asOf'),
            held: $data['held'] ?? null,
            nextReleaseAt: $data['nextReleaseAt'] ?? null,
            availableUsdt: $data['availableUsdt'] ?? null,
            pendingPayoutUsdt: $data['pendingPayoutUsdt'] ?? null,
            heldUsdt: $data['heldUsdt'] ?? null,
        ))->withRaw($data);
    }
}
