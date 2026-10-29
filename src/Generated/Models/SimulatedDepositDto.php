<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class SimulatedDepositDto extends Model
{
    public function __construct(
        public readonly string $paymentId,
        public readonly SimulatedDepositDtoStatus|string $status,
        public readonly SimulatedDepositDtoMethod|string $method,
        public readonly SimulatedDepositDtoCurrency|string $currency,
        /**
         * Amount received, in `currency`.
         */
        public readonly string $amount,
        /**
         * Your stablecoin fee, in `currency`. The balance is credited `amount` − `fee`.
         */
        public readonly string $fee,
        public readonly string $network,
        public readonly string $customerRef,
        /**
         * Always empty: nothing moved on chain.
         *
         * @var list<string>
         */
        public readonly array $txHashes,
        /**
         * Always false: simulated deposits exist in Test mode only.
         */
        public readonly bool $livemode,
        public readonly bool $simulated,
        public readonly string $createdAt,
        /**
         * USDT only: same as `amount`.
         */
        public readonly ?string $amountUsdt = null,
        /**
         * USDT only: same as `fee`.
         */
        public readonly ?string $feeUsdt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            paymentId: self::required($data, 'paymentId'),
            status: self::enumOrRaw(SimulatedDepositDtoStatus::class, self::required($data, 'status')),
            method: self::enumOrRaw(SimulatedDepositDtoMethod::class, self::required($data, 'method')),
            currency: self::enumOrRaw(SimulatedDepositDtoCurrency::class, self::required($data, 'currency')),
            amount: self::required($data, 'amount'),
            fee: self::required($data, 'fee'),
            network: self::required($data, 'network'),
            customerRef: self::required($data, 'customerRef'),
            txHashes: self::required($data, 'txHashes'),
            livemode: self::required($data, 'livemode'),
            simulated: self::required($data, 'simulated'),
            createdAt: self::required($data, 'createdAt'),
            amountUsdt: $data['amountUsdt'] ?? null,
            feeUsdt: $data['feeUsdt'] ?? null,
        ))->withRaw($data);
    }
}
