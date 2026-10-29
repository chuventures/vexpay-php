<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class SimulateDepositDto extends Model
{
    public function __construct(
        /**
         * The `customerRef` of a deposit address you already requested.
         */
        public readonly string $customerRef,
        /**
         * Network of that deposit address.
         */
        public readonly SimulateDepositDtoNetwork|string $network,
        /**
         * Amount that "arrives", in `currency`: greater than 0, at most 10,000, at most 2 decimals.
         */
        public readonly string|float $amount,
        /**
         * Stablecoin of that deposit address.
         */
        public readonly SimulateDepositDtoCurrency|string|null $currency = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            customerRef: self::required($data, 'customerRef'),
            network: self::enumOrRaw(SimulateDepositDtoNetwork::class, self::required($data, 'network')),
            amount: self::required($data, 'amount'),
            currency: isset($data['currency']) ? self::enumOrRaw(SimulateDepositDtoCurrency::class, $data['currency']) : null,
        ))->withRaw($data);
    }
}
