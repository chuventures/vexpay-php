<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayoutResponseDto extends Model
{
    public function __construct(
        /**
         * Payout id. Empty string only on batch item failures that never created a row.
         */
        public readonly string $payoutId,
        /**
         * `pending` means the credit is still reconciling (AC00); subscribe to payout webhooks or poll GET /v1/payouts/:id. `awaiting_approval` means the funds are reserved but the payout is held for VEX Pay review (see `holdReason`) and has not been sent; it later becomes `pending`/`completed` when approved or `failed` (`rejected_new_account_limit`, funds returned) when rejected.
         */
        public readonly PayoutResponseDtoStatus|string $status,
        /**
         * Why the payout was held for review. `NEW_ACCOUNT_LIMIT`: the tenant or merchant is new (first 30 days) and this payout would take its rolling 24h money-out above the new-account cap (default US$300 equivalent).
         */
        public readonly PayoutResponseDtoHoldReason|string|null $holdReason = null,
        /**
         * Bank reference when available.
         */
        public readonly ?string $reference = null,
        /**
         * Machine-readable failure when status is failed (e.g. merchant_inactive, payout_method_not_verified).
         */
        public readonly ?string $failureCode = null,
        /**
         * Tenant-supplied idempotency / lookup key.
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
            status: self::enumOrRaw(PayoutResponseDtoStatus::class, self::required($data, 'status')),
            holdReason: isset($data['holdReason']) ? self::enumOrRaw(PayoutResponseDtoHoldReason::class, $data['holdReason']) : null,
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
