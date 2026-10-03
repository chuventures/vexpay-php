<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class VposPaymentDto extends Model
{
    public function __construct(
        /**
         * Handle only in a PCI-compliant server environment.
         */
        public readonly string $cardNumber,
        public readonly float $expirationMonth,
        public readonly float $expirationYear,
        public readonly string $cvv,
        public readonly string $cardHolderName,
        public readonly string $cardHolderId,
        /**
         * 0 credit, 10 savings, 20 checking.
         */
        public readonly float $accountType,
        /**
         * Provider card-brand code.
         */
        public readonly float $cardType,
        /**
         * USD amount. Required unless vesAmount is set. When only usdAmount is set, VES is derived at the live BCV rate.
         */
        public readonly ?float $usdAmount = null,
        /**
         * VES amount charged at the bank. When set, locks the bolívar charge and derives USD at BCV — use this to avoid USD↔VES 2-decimal round-trip drift (e.g. Bs. 50 → $0.07 → Bs. 52.86).
         */
        public readonly ?float $vesAmount = null,
        /**
         * Card PIN (4 digits). Optional; defaults to 0000 when omitted.
         */
        public readonly ?string $cardPin = null,
        /**
         * Correlation value; not an idempotency key.
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
            cardNumber: self::required($data, 'cardNumber'),
            expirationMonth: self::required($data, 'expirationMonth'),
            expirationYear: self::required($data, 'expirationYear'),
            cvv: self::required($data, 'cvv'),
            cardHolderName: self::required($data, 'cardHolderName'),
            cardHolderId: self::required($data, 'cardHolderId'),
            accountType: self::required($data, 'accountType'),
            cardType: self::required($data, 'cardType'),
            usdAmount: $data['usdAmount'] ?? null,
            vesAmount: $data['vesAmount'] ?? null,
            cardPin: $data['cardPin'] ?? null,
            externalRef: $data['externalRef'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            applicationFeeVes: $data['applicationFeeVes'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
        ))->withRaw($data);
    }
}
