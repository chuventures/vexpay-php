<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PlatformBalanceDto extends Model
{
    public function __construct(
        public readonly string $tenantId,
        public readonly string $platformId,
        public readonly string $collectedVes,
        public readonly string $feesVes,
        public readonly string $paidOutVes,
        /**
         * Net VES spent on VES→USDT conversions.
         */
        public readonly string $convertedVes,
        /**
         * Net card chargeback fees charged (fees minus fees returned on won disputes).
         */
        public readonly string $chargebackFeesVes,
        public readonly string $reserveVes,
        public readonly string $ledgerNetVes,
        /**
         * Tenant spendable float after reserve (seller obligations already deducted via SELLER_TRANSFER).
         */
        public readonly string $availableVes,
        public readonly string $platformAvailableVes,
        /**
         * Sum of seller pending + available obligations.
         */
        public readonly string $sellerObligationsVes,
        public readonly string $sellerPendingVes,
        public readonly string $sellerAvailableVes,
        public readonly string $feePercent,
        public readonly string $feeFixedUsd,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            tenantId: self::required($data, 'tenantId'),
            platformId: self::required($data, 'platformId'),
            collectedVes: self::required($data, 'collectedVes'),
            feesVes: self::required($data, 'feesVes'),
            paidOutVes: self::required($data, 'paidOutVes'),
            convertedVes: self::required($data, 'convertedVes'),
            chargebackFeesVes: self::required($data, 'chargebackFeesVes'),
            reserveVes: self::required($data, 'reserveVes'),
            ledgerNetVes: self::required($data, 'ledgerNetVes'),
            availableVes: self::required($data, 'availableVes'),
            platformAvailableVes: self::required($data, 'platformAvailableVes'),
            sellerObligationsVes: self::required($data, 'sellerObligationsVes'),
            sellerPendingVes: self::required($data, 'sellerPendingVes'),
            sellerAvailableVes: self::required($data, 'sellerAvailableVes'),
            feePercent: self::required($data, 'feePercent'),
            feeFixedUsd: self::required($data, 'feeFixedUsd'),
        ))->withRaw($data);
    }
}
