<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CryptoPayoutDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly CryptoPayoutDtoCurrency|string $currency,
        public readonly CryptoPayoutDtoStatus|string $status,
        public readonly string $network,
        public readonly string $address,
        /**
         * Amount sent, in `currency`.
         */
        public readonly string $amount,
        /**
         * Network fee + margin, in `currency` (0 for internal).
         */
        public readonly string $fee,
        public readonly string $idempotencyKey,
        /**
         * Settled inside VEXPay (destination is one of your own deposit addresses).
         */
        public readonly bool $internal,
        public readonly string $createdAt,
        public readonly ?string $tag = null,
        /**
         * USDT only: same as `amount`.
         */
        public readonly ?string $amountUsdt = null,
        /**
         * USDT only: same as `fee`.
         */
        public readonly ?string $feeUsdt = null,
        public readonly ?string $customerRef = null,
        public readonly ?string $merchantId = null,
        public readonly ?string $txHash = null,
        public readonly ?string $failureReason = null,
        public readonly ?string $completedAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            object: self::required($data, 'object'),
            currency: self::enumOrRaw(CryptoPayoutDtoCurrency::class, self::required($data, 'currency')),
            status: self::enumOrRaw(CryptoPayoutDtoStatus::class, self::required($data, 'status')),
            network: self::required($data, 'network'),
            address: self::required($data, 'address'),
            amount: self::required($data, 'amount'),
            fee: self::required($data, 'fee'),
            idempotencyKey: self::required($data, 'idempotencyKey'),
            internal: self::required($data, 'internal'),
            createdAt: self::required($data, 'createdAt'),
            tag: $data['tag'] ?? null,
            amountUsdt: $data['amountUsdt'] ?? null,
            feeUsdt: $data['feeUsdt'] ?? null,
            customerRef: $data['customerRef'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            txHash: $data['txHash'] ?? null,
            failureReason: $data['failureReason'] ?? null,
            completedAt: $data['completedAt'] ?? null,
        ))->withRaw($data);
    }
}
