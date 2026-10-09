<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class C2pRequestDto extends Model
{
    public function __construct(
        public readonly string $debtorId,
        /**
         * Country code 58 followed by 10 digits.
         */
        public readonly string $debtorCellPhone,
        /**
         * Venezuelan bank institution code (e.g. 102, 105, 134). Must match a bank from GET /v1/banks.
         */
        public readonly float $debtorBankCode,
        /**
         * USD amount. Required unless vesAmount is set. When only usdAmount is set, VES is derived at the live BCV rate.
         */
        public readonly ?float $usdAmount = null,
        /**
         * VES amount debited at the bank. When set, locks the bolívar charge and derives USD at BCV (it wins over usdAmount). The intent keeps this amount until it is executed.
         */
        public readonly ?float $vesAmount = null,
        /**
         * Correlation value; not an idempotency key. When present, any other PENDING C2P intent for this tenant + externalRef is canceled (superseded) before the new intent is created.
         */
        public readonly ?string $externalRef = null,
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
            usdAmount: $data['usdAmount'] ?? null,
            vesAmount: $data['vesAmount'] ?? null,
            externalRef: $data['externalRef'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            applicationFeeVes: $data['applicationFeeVes'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
        ))->withRaw($data);
    }
}
