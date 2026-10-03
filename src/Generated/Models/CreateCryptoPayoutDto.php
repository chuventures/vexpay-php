<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateCryptoPayoutDto extends Model
{
    public function __construct(
        /**
         * USDT: TRC20, BEP20, POLYGON, SOL, TON, ARB1. USDC: POLYGON, BASE.
         */
        public readonly CreateCryptoPayoutDtoNetwork|string $network,
        public readonly string $address,
        /**
         * Unique per payout. Replays return the same payout (200).
         */
        public readonly string $idempotencyKey,
        /**
         * Stablecoin to send; debits that balance.
         */
        public readonly CreateCryptoPayoutDtoCurrency|string|null $currency = null,
        /**
         * Destination tag / memo (required on TON).
         */
        public readonly ?string $tag = null,
        /**
         * Amount the destination receives, in `currency` (max 2 decimals).
         */
        public readonly ?string $amount = null,
        /**
         * USDT only: alias of `amount`.
         */
        public readonly ?string $amountUsdt = null,
        /**
         * Your customer reference, echoed on webhooks.
         */
        public readonly ?string $customerRef = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            network: self::enumOrRaw(CreateCryptoPayoutDtoNetwork::class, self::required($data, 'network')),
            address: self::required($data, 'address'),
            idempotencyKey: self::required($data, 'idempotencyKey'),
            currency: isset($data['currency']) ? self::enumOrRaw(CreateCryptoPayoutDtoCurrency::class, $data['currency']) : null,
            tag: $data['tag'] ?? null,
            amount: $data['amount'] ?? null,
            amountUsdt: $data['amountUsdt'] ?? null,
            customerRef: $data['customerRef'] ?? null,
        ))->withRaw($data);
    }
}
