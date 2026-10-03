<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayoutRecipientDto extends Model
{
    public function __construct(
        /**
         * Beneficiary legal name.
         */
        public readonly string $nombres,
        /**
         * Beneficiary documento (V/E/J/P + digits).
         */
        public readonly string $documento,
        /**
         * 20-digit destination account number.
         */
        public readonly string $destino,
        /**
         * Share for this beneficiary (VES). Sum of montoPart must equal monto.
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
            nombres: self::required($data, 'nombres'),
            documento: self::required($data, 'documento'),
            destino: self::required($data, 'destino'),
            montoPart: self::required($data, 'montoPart'),
        ))->withRaw($data);
    }
}
