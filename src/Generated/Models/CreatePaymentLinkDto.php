<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreatePaymentLinkDto extends Model
{
    public function __construct(
        /**
         * URL slug for the hosted checkout. Lowercase letters, digits, hyphens. Auto-generated from the product name when omitted.
         */
        public readonly ?string $slug = null,
        /**
         * Let the buyer choose a quantity.
         */
        public readonly ?bool $allowQuantity = null,
        public readonly ?float $maxQuantity = null,
        /**
         * Where to send the buyer after a successful payment.
         */
        public readonly ?string $redirectUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            slug: $data['slug'] ?? null,
            allowQuantity: $data['allowQuantity'] ?? null,
            maxQuantity: $data['maxQuantity'] ?? null,
            redirectUrl: $data['redirectUrl'] ?? null,
        ))->withRaw($data);
    }
}
