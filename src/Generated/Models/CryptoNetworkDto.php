<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CryptoNetworkDto extends Model
{
    public function __construct(
        public readonly CryptoNetworkDtoCurrency|string $currency,
        public readonly string $network,
        public readonly string $displayName,
        public readonly bool $receiveEnabled,
        public readonly bool $payoutEnabled,
        /**
         * Payout fee in `currency`.
         */
        public readonly string $payoutFee,
        /**
         * Minimum payout in `currency`.
         */
        public readonly string $minPayout,
        public readonly bool $tagRequired,
        /**
         * Whether a payout of the requested amount can be sent on this network now.
         */
        public readonly bool $available,
        /**
         * USDT only: same as `payoutFee`.
         */
        public readonly ?string $payoutFeeUsdt = null,
        /**
         * USDT only: same as `minPayout`.
         */
        public readonly ?string $minPayoutUsdt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            currency: self::enumOrRaw(CryptoNetworkDtoCurrency::class, self::required($data, 'currency')),
            network: self::required($data, 'network'),
            displayName: self::required($data, 'displayName'),
            receiveEnabled: self::required($data, 'receiveEnabled'),
            payoutEnabled: self::required($data, 'payoutEnabled'),
            payoutFee: self::required($data, 'payoutFee'),
            minPayout: self::required($data, 'minPayout'),
            tagRequired: self::required($data, 'tagRequired'),
            available: self::required($data, 'available'),
            payoutFeeUsdt: $data['payoutFeeUsdt'] ?? null,
            minPayoutUsdt: $data['minPayoutUsdt'] ?? null,
        ))->withRaw($data);
    }
}
