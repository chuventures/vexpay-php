<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayoutBatchItemResultDto extends Model
{
    public function __construct(
        /**
         * Payout id. Empty string only on batch item failures that never created a row.
         */
        public readonly string $payoutId,
        /**
         * `pending` means the credit is still reconciling (AC00); subscribe to payout webhooks or poll GET /v1/payouts/:id.
         */
        public readonly PayoutBatchItemResultDtoStatus|string $status,
        /**
         * Bank reference when available.
         */
        public readonly ?string $reference = null,
        /**
         * Machine-readable failure when status is failed (e.g. merchant_inactive, payout_method_not_verified).
         */
        public readonly ?string $failureCode = null,
        /**
         * Echo of the item-level externalRef from the request (idempotency key).
         */
        public readonly ?string $externalRef = null,
        /**
         * Funding payment when this payout is a marketplace settlement leg.
         */
        public readonly ?string $paymentId = null,
        public readonly ?string $merchantId = null,
        public readonly ?string $payoutMethodId = null,
        public readonly ?string $merchantName = null,
        /**
         * Net two-decimal VES amount credited at the bank.
         */
        public readonly ?string $monto = null,
        /**
         * Gross VES withdrawn from the ledger (instant tenant credits only).
         */
        public readonly ?string $grossMonto = null,
        /**
         * Platform fee percent applied on instant tenant credits.
         */
        public readonly ?string $feePercent = null,
        /**
         * Platform fee in VES retained on instant tenant credits.
         */
        public readonly ?string $feeVes = null,
        public readonly ?string $concepto = null,
        /**
         * Destination bank SIMF code.
         */
        public readonly ?string $bankCode = null,
        /**
         * Masked phone destination, e.g. …5555
         */
        public readonly ?string $destination = null,
        /**
         * Network operation id while pending reconciliation.
         */
        public readonly ?string $operationId = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $settledAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            payoutId: self::required($data, 'payoutId'),
            status: self::enumOrRaw(PayoutBatchItemResultDtoStatus::class, self::required($data, 'status')),
            reference: $data['reference'] ?? null,
            failureCode: $data['failureCode'] ?? null,
            externalRef: $data['externalRef'] ?? null,
            paymentId: $data['paymentId'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            payoutMethodId: $data['payoutMethodId'] ?? null,
            merchantName: $data['merchantName'] ?? null,
            monto: $data['monto'] ?? null,
            grossMonto: $data['grossMonto'] ?? null,
            feePercent: $data['feePercent'] ?? null,
            feeVes: $data['feeVes'] ?? null,
            concepto: $data['concepto'] ?? null,
            bankCode: $data['bankCode'] ?? null,
            destination: $data['destination'] ?? null,
            operationId: $data['operationId'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            settledAt: $data['settledAt'] ?? null,
        ))->withRaw($data);
    }
}
