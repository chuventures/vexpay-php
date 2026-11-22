<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateMerchantDto extends Model
{
    public function __construct(
        public readonly string $externalRef,
        public readonly string $name,
        /**
         * V/E+8 or J/G+9
         */
        public readonly string $identification,
        public readonly string $contactEmail,
        public readonly string $contactPhone,
        /**
         * Optional 4-digit SIMF bank code for the first Pago Móvil payout method. Provide together with phone, or omit both to create a merchant shell with no payout method.
         */
        public readonly ?string $bankCode = null,
        /**
         * Optional 11-digit local Pago Móvil phone for the first payout method. Provide together with bankCode, or omit both.
         */
        public readonly ?string $phone = null,
        /**
         * Pay this merchant's available balance automatically every 15 minutes. Omit it to use your account's `merchantAutoPayoutDefault` (GET /v1/marketplace/settings). Used only when the merchant is created; change it later with PATCH /v1/merchants/{id}.
         */
        public readonly ?bool $autoPayoutEnabled = null,
        /**
         * Negotiated marketplace commission (percent of vesAmount) retained from payments tagged with this merchant when the request sends no applicationFeeVes / applicationFeePercent. Omit it (or send null) to use the tenant's default commission. Used only when the merchant is created; change it later with PATCH /v1/merchants/{id}.
         */
        public readonly ?float $applicationFeePercent = null,
        /**
         * Hosted-checkout brand color for this merchant's links, as `#RRGGBB` (stored uppercase). The checkout derives an accessible palette from it for light and dark mode. Omit or send null to use your account's brand color.
         */
        public readonly ?string $brandColor = null,
        /**
         * Name buyers see on the hosted checkout for this merchant, 1–60 characters on one line. Omit it (or send null) to show `name`. Change it later with PATCH /v1/merchants/{id}.
         */
        public readonly ?string $displayName = null,
        /**
         * Public https URL of the merchant's logo (PNG, JPEG or WebP, up to 2 MB). VEX Pay downloads it once, stores its own square PNG copy and returns that copy's URL as `logoUrl`; the hosted checkout shows it in the seller header. An unreachable URL or a file that is not an image answers 400 and nothing is created.
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
            externalRef: self::required($data, 'externalRef'),
            name: self::required($data, 'name'),
            identification: self::required($data, 'identification'),
            contactEmail: self::required($data, 'contactEmail'),
            contactPhone: self::required($data, 'contactPhone'),
            bankCode: $data['bankCode'] ?? null,
            phone: $data['phone'] ?? null,
            autoPayoutEnabled: $data['autoPayoutEnabled'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
            brandColor: $data['brandColor'] ?? null,
            displayName: $data['displayName'] ?? null,
            logoUrl: $data['logoUrl'] ?? null,
        ))->withRaw($data);
    }
}
