<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class OnwardPayoutStatusDto extends Model
{
    public function __construct(
        public readonly OnwardPayoutStatusDtoStatus|string $status,
        public readonly string $network,
        public readonly string $address,
        public readonly string $updatedAt,
        public readonly ?string $tag = null,
        /**
         * The VES → USDT conversion, once created.
         */
        public readonly ?string $conversionId = null,
        /**
         * The USDT payout, once created.
         */
        public readonly ?string $payoutId = null,
        /**
         * USDT sent to the address.
         */
        public readonly ?string $amountUsdt = null,
        /**
         * Network payout fee.
         */
        public readonly ?string $feeUsdt = null,
        /**
         * On-chain hash once the payout completed.
         */
        public readonly ?string $txHash = null,
        /**
         * Why it is held, failed or canceled.
         */
        public readonly ?string $reason = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            status: self::enumOrRaw(OnwardPayoutStatusDtoStatus::class, self::required($data, 'status')),
            network: self::required($data, 'network'),
            address: self::required($data, 'address'),
            updatedAt: self::required($data, 'updatedAt'),
            tag: $data['tag'] ?? null,
            conversionId: $data['conversionId'] ?? null,
            payoutId: $data['payoutId'] ?? null,
            amountUsdt: $data['amountUsdt'] ?? null,
            feeUsdt: $data['feeUsdt'] ?? null,
            txHash: $data['txHash'] ?? null,
            reason: $data['reason'] ?? null,
        ))->withRaw($data);
    }
}
