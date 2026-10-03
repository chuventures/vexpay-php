<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class C2pIntentResponseDto extends Model
{
    public function __construct(
        public readonly string $paymentId,
        public readonly C2pIntentResponseDtoStatus|string $status,
        public readonly C2pIntentResponseDtoMethod|string $method,
        public readonly float $usdAmount,
        public readonly float $vesAmount,
        public readonly float $bcvRate,
        public readonly string $tenantName,
        public readonly string $createdAt,
        /**
         * Use this value as intentId when executing the C2P charge.
         */
        public readonly string $intentId,
        /**
         * true when the provider instructed the payer bank to SMS an OTP to the customer. false when the customer must generate the token in their bank app.
         */
        public readonly bool $otpRequested,
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
        public readonly C2pIntentResponseDtoCancelReason|string|null $cancelReason = null,
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
            status: self::enumOrRaw(C2pIntentResponseDtoStatus::class, self::required($data, 'status')),
            method: self::enumOrRaw(C2pIntentResponseDtoMethod::class, self::required($data, 'method')),
            usdAmount: self::required($data, 'usdAmount'),
            vesAmount: self::required($data, 'vesAmount'),
            bcvRate: self::required($data, 'bcvRate'),
            tenantName: self::required($data, 'tenantName'),
            createdAt: self::required($data, 'createdAt'),
            intentId: self::required($data, 'intentId'),
            otpRequested: self::required($data, 'otpRequested'),
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
            cancelReason: isset($data['cancelReason']) ? self::enumOrRaw(C2pIntentResponseDtoCancelReason::class, $data['cancelReason']) : null,
            reversedAt: $data['reversedAt'] ?? null,
            reversalRef: $data['reversalRef'] ?? null,
            reversalTxId: $data['reversalTxId'] ?? null,
        ))->withRaw($data);
    }
}
