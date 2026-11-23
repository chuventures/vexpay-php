<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateOneShotPaymentLinkDto extends Model
{
    public function __construct(
        /**
         * USD, positive, up to 2 decimals. Fixed at creation; at least your minimum charge.
         */
        public readonly string $amount,
        /**
         * Shown to the buyer on the hosted checkout.
         */
        public readonly string $description,
        /**
         * Private to you; echoed on reads and in payment.* webhooks.
         */
        public readonly ?string $reference = null,
        /**
         * Optional expiry, in the future. Without it the link stays open until paid or cancelled.
         */
        public readonly ?string $expiresAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amount: self::required($data, 'amount'),
            description: self::required($data, 'description'),
            reference: $data['reference'] ?? null,
            expiresAt: $data['expiresAt'] ?? null,
        ))->withRaw($data);
    }
}
