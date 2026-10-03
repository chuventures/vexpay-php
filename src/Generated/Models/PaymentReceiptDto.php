<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentReceiptDto extends Model
{
    public function __construct(
        public readonly string $paymentId,
        public readonly PaymentReceiptDtoStatus|string $status,
        public readonly PaymentReceiptDtoMethod|string $method,
        public readonly float $usdAmount,
        public readonly float $vesAmount,
        public readonly float $bcvRate,
        public readonly string $tenantName,
        public readonly string $createdAt,
        /**
         * Tenant correlation value; not an idempotency key.
         */
        public readonly ?string $externalRef = null,
        /**
         * Platform service fee, USD. Clamped 0..usdAmount.
         */
        public readonly ?float $feeUsd = null,
        /**
         * Platform service fee, VES. Clamped 0..vesAmount.
         */
        public readonly ?float $feeVes = null,
        /**
         * What the seller receives: vesAmount − platform fee − application fee, floored at 0.
         */
        public readonly ?float $netVes = null,
        public readonly ?string $bankReference = null,
        public readonly ?float $bankTxId = null,
        public readonly ?string $debtorId = null,
        public readonly ?string $debtorPhone = null,
        public readonly ?float $debtorBankCode = null,
        public readonly ?string $debtorBankName = null,
        public readonly ?string $cardLast4 = null,
        public readonly ?string $cardBrand = null,
        public readonly ?string $cardProduct = null,
        public readonly ?string $accountTypeLabel = null,
        public readonly ?string $failureCode = null,
        /**
         * Present when status is CANCELED. superseded = replaced by a newer intent; expired = abandoned after TTL.
         */
        public readonly PaymentReceiptDtoCancelReason|string|null $cancelReason = null,
        public readonly ?string $reversedAt = null,
        public readonly ?string $reversalRef = null,
        public readonly ?float $reversalTxId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            paymentId: self::required($data, 'paymentId'),
            status: self::enumOrRaw(PaymentReceiptDtoStatus::class, self::required($data, 'status')),
            method: self::enumOrRaw(PaymentReceiptDtoMethod::class, self::required($data, 'method')),
            usdAmount: self::required($data, 'usdAmount'),
            vesAmount: self::required($data, 'vesAmount'),
            bcvRate: self::required($data, 'bcvRate'),
            tenantName: self::required($data, 'tenantName'),
            createdAt: self::required($data, 'createdAt'),
            externalRef: $data['externalRef'] ?? null,
            feeUsd: $data['feeUsd'] ?? null,
            feeVes: $data['feeVes'] ?? null,
            netVes: $data['netVes'] ?? null,
            bankReference: $data['bankReference'] ?? null,
            bankTxId: $data['bankTxId'] ?? null,
            debtorId: $data['debtorId'] ?? null,
            debtorPhone: $data['debtorPhone'] ?? null,
            debtorBankCode: $data['debtorBankCode'] ?? null,
            debtorBankName: $data['debtorBankName'] ?? null,
            cardLast4: $data['cardLast4'] ?? null,
            cardBrand: $data['cardBrand'] ?? null,
            cardProduct: $data['cardProduct'] ?? null,
            accountTypeLabel: $data['accountTypeLabel'] ?? null,
            failureCode: $data['failureCode'] ?? null,
            cancelReason: isset($data['cancelReason']) ? self::enumOrRaw(PaymentReceiptDtoCancelReason::class, $data['cancelReason']) : null,
            reversedAt: $data['reversedAt'] ?? null,
            reversalRef: $data['reversalRef'] ?? null,
            reversalTxId: $data['reversalTxId'] ?? null,
        ))->withRaw($data);
    }
}
