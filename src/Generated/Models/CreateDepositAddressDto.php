<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateDepositAddressDto extends Model
{
    public function __construct(
        /**
         * Your identifier for the customer this address belongs to (1–128 chars: A–Z a–z 0–9 _ . : @ -).
         */
        public readonly string $customerRef,
        /**
         * USDT: TRC20, BEP20, POLYGON, SOL, TON, ARB1. USDC: POLYGON, BASE.
         */
        public readonly CreateDepositAddressDtoNetwork|string $network,
        /**
         * Stablecoin the address receives.
         */
        public readonly CreateDepositAddressDtoCurrency|string|null $currency = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            customerRef: self::required($data, 'customerRef'),
            network: self::enumOrRaw(CreateDepositAddressDtoNetwork::class, self::required($data, 'network')),
            currency: isset($data['currency']) ? self::enumOrRaw(CreateDepositAddressDtoCurrency::class, $data['currency']) : null,
        ))->withRaw($data);
    }
}
