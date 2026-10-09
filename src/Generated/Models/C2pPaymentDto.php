<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class C2pPaymentDto extends Model
{
    public function __construct(
        public readonly string $debtorId,
        public readonly string $debtorCellPhone,
        /**
         * Venezuelan bank institution code (e.g. 102, 105, 134). Must match a bank from GET /v1/banks.
         */
        public readonly float $debtorBankCode,
        /**
         * Bank-issued token collected by the tenant from the customer.
         */
        public readonly string $token,
        /**
         * Pending intent returned by POST /v1/payments/c2p/request.
         */
        public readonly ?string $intentId = null,
        /**
         * USD amount. Required unless vesAmount or intentId is set. When only usdAmount is set, VES is derived at the live BCV rate.
         */
        public readonly ?float $usdAmount = null,
        /**
         * VES amount debited at the bank. When set, locks the bolívar charge and derives USD at BCV (it wins over usdAmount). With intentId the amount locked on the intent is charged; amounts sent here must match it (±0.01 Bs / ±$0.01).
         */
        public readonly ?float $vesAmount = null,
        /**
         * Correlation value; not an idempotency key.
         */
        public readonly ?string $externalRef = null,
        /**
         * Seller merchant to auto-credit on payment.completed (net = ves − plan fee − applicationFee).
         */
        public readonly ?string $merchantId = null,
        /**
         * Marketplace application fee in VES retained by the platform.
         */
        public readonly ?string $applicationFeeVes = null,
        /**
         * Optional percent of vesAmount used when applicationFeeVes is omitted. When both are omitted and merchantId is set, the merchant's commission (or the tenant default commission) applies.
         */
        public readonly ?float $applicationFeePercent = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            debtorId: self::required($data, 'debtorId'),
            debtorCellPhone: self::required($data, 'debtorCellPhone'),
            debtorBankCode: self::required($data, 'debtorBankCode'),
            token: self::required($data, 'token'),
            intentId: $data['intentId'] ?? null,
            usdAmount: $data['usdAmount'] ?? null,
            vesAmount: $data['vesAmount'] ?? null,
            externalRef: $data['externalRef'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            applicationFeeVes: $data['applicationFeeVes'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
        ))->withRaw($data);
    }
}
