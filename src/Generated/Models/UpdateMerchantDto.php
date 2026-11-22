<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

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
        /**
         * Hosted-checkout brand color for this merchant's links, as `#RRGGBB` (stored uppercase). The checkout derives an accessible palette from it for light and dark mode. Omit or send null to use your account's brand color. null clears it.
         */
        public readonly ?string $brandColor = null,
        /**
         * Name buyers see on the hosted checkout, 1–60 characters on one line. null clears it so `name` shows again. `name` itself is the name given at creation and cannot be changed.
         */
        public readonly ?string $displayName = null,
        /**
         * Public https URL of the merchant's logo (PNG, JPEG or WebP, up to 2 MB). VEX Pay downloads it once and stores its own square PNG copy (returned as `logoUrl`). null removes the logo. An unreachable URL or a file that is not an image answers 400 and the current logo is kept.
         */
        public readonly ?string $logoUrl = null,
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
            brandColor: $data['brandColor'] ?? null,
            displayName: $data['displayName'] ?? null,
            logoUrl: $data['logoUrl'] ?? null,
        ))->withRaw($data);
    }
}
