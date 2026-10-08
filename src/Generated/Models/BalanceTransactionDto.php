<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class BalanceTransactionDto extends Model
{
    public function __construct(
        /**
         * Stable id of the movement; never changes or disappears.
         */
        public readonly string $id,
        public readonly BalanceTransactionDtoType|string $type,
        /**
         * Signed VES amount (negative = money out of your balance).
         */
        public readonly string $amountVes,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly ?string $paymentId = null,
        public readonly ?string $payoutId = null,
        /**
         * Present on chargeback movements.
         */
        public readonly ?string $chargebackId = null,
        public readonly ?string $merchantId = null,
        /**
         * externalRef of the linked payment or payout.
         */
        public readonly ?string $externalRef = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            type: self::enumOrRaw(BalanceTransactionDtoType::class, self::required($data, 'type')),
            amountVes: self::required($data, 'amountVes'),
            description: self::required($data, 'description'),
            createdAt: self::required($data, 'createdAt'),
            paymentId: $data['paymentId'] ?? null,
            payoutId: $data['payoutId'] ?? null,
            chargebackId: $data['chargebackId'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            externalRef: $data['externalRef'] ?? null,
        ))->withRaw($data);
    }
}
