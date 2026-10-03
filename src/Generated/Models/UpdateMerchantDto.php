<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdateMerchantDto extends Model
{
    public function __construct(
        /**
         * Soft off-switch for payouts. false = deactivated (history kept).
         */
        public readonly ?bool $isActive = null,
        /**
         * When true, a cron job automatically pays available seller balance to the default verified Pago Móvil method.
         */
        public readonly ?bool $autoPayoutEnabled = null,
        /**
         * Negotiated marketplace commission (percent of vesAmount) retained from payments tagged with this merchant when the request sends no applicationFeeVes / applicationFeePercent. null clears the override so the tenant's default commission applies.
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
            isActive: $data['isActive'] ?? null,
            autoPayoutEnabled: $data['autoPayoutEnabled'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
        ))->withRaw($data);
    }
}
