<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateTopupDto extends Model
{
    public function __construct(
        /**
         * Bs to load, two decimals, above 0.
         */
        public readonly string $amountVes,
        /**
         * Phone the Pago Móvil is sent from (Venezuelan mobile, 04XXXXXXXXX).
         */
        public readonly string $payerPhone,
        /**
         * Cédula or RIF of the payer.
         */
        public readonly string $payerCedula,
        /**
         * Where the money comes from (10–500 characters). Visible to VEX Pay ops.
         */
        public readonly string $sourceNote,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amountVes: self::required($data, 'amountVes'),
            payerPhone: self::required($data, 'payerPhone'),
            payerCedula: self::required($data, 'payerCedula'),
            sourceNote: self::required($data, 'sourceNote'),
        ))->withRaw($data);
    }
}
