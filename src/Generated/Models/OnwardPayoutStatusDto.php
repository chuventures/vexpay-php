<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class OnwardPayoutStatusDto extends Model
{
    public function __construct(
        /**
         * `waiting_release`: converted, waiting before sending until the balance hold ends (see `sendAfter`) or, with `reason: awaiting_bank_confirmation`, until the bank confirms the paid VES.
         */
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
         * Why it is waiting, held, failed or canceled (`awaiting_bank_confirmation` while the bank has not confirmed the paid VES).
         */
        public readonly ?string $reason = null,
        /**
         * `waiting_release` only: when the converted USDT leaves the balance hold and the payout is sent. Omitted while waiting for bank confirmation.
         */
        public readonly ?string $sendAfter = null,
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
            sendAfter: $data['sendAfter'] ?? null,
        ))->withRaw($data);
    }
}
