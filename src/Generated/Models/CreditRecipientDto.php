<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreditRecipientDto extends Model
{
    public function __construct(
        /**
         * Recipient bank code (3–4 digits).
         */
        public readonly string $banco,
        /**
         * Recipient cédula/RIF.
         */
        public readonly string $cedula,
        /**
         * Recipient Pago Móvil phone.
         */
        public readonly string $telefono,
        /**
         * Share of the total disbursement for this recipient (VES). Sum of montoPart must equal monto.
         */
        public readonly float $montoPart,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            banco: self::required($data, 'banco'),
            cedula: self::required($data, 'cedula'),
            telefono: self::required($data, 'telefono'),
            montoPart: self::required($data, 'montoPart'),
        ))->withRaw($data);
    }
}
