<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CheckoutSessionPaymentInProgressDto extends Model
{
    public function __construct(
        /**
         * Bolívars received so far.
         */
        public readonly string $paidVesAmount,
        /**
         * Bolívars still missing.
         */
        public readonly string $missingVesAmount,
        /**
         * When the payment ends if the rest does not arrive (ISO 8601).
         */
        public readonly string $expiresAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            paidVesAmount: self::required($data, 'paidVesAmount'),
            missingVesAmount: self::required($data, 'missingVesAmount'),
            expiresAt: self::required($data, 'expiresAt'),
        ))->withRaw($data);
    }
}
