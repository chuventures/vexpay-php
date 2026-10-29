<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantMovementDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly MerchantMovementDtoType|string $type,
        /**
         * Signed change of the total balance (pending + available). A `release` row is 0.00.
         */
        public readonly string $amountVes,
        public readonly string $description,
        public readonly string $createdAt,
        /**
         * `release` rows only: VES moved from pending to available (negative = put back on hold).
         */
        public readonly ?string $releasedVes = null,
        /**
         * `credit` rows: the transferKey you sent.
         */
        public readonly ?string $transferKey = null,
        public readonly ?string $paymentId = null,
        public readonly ?string $payoutId = null,
        /**
         * `credit` rows: when the credit becomes withdrawable.
         */
        public readonly ?string $availableAt = null,
        /**
         * Credits sent with `amountUsd`: the USD amount.
         */
        public readonly ?string $amountUsd = null,
        /**
         * Credits sent with `amountUsd`: the rate used.
         */
        public readonly ?string $rate = null,
        public readonly ?string $rateSource = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            type: self::enumOrRaw(MerchantMovementDtoType::class, self::required($data, 'type')),
            amountVes: self::required($data, 'amountVes'),
            description: self::required($data, 'description'),
            createdAt: self::required($data, 'createdAt'),
            releasedVes: $data['releasedVes'] ?? null,
            transferKey: $data['transferKey'] ?? null,
            paymentId: $data['paymentId'] ?? null,
            payoutId: $data['payoutId'] ?? null,
            availableAt: $data['availableAt'] ?? null,
            amountUsd: $data['amountUsd'] ?? null,
            rate: $data['rate'] ?? null,
            rateSource: $data['rateSource'] ?? null,
        ))->withRaw($data);
    }
}
