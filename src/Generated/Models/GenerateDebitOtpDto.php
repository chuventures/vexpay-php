<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class GenerateDebitOtpDto extends Model
{
    public function __construct(
        /**
         * 3–4 digit bank code (padded to 4 digits when sent to the network). Prefer codes from GET /v1/banks.
         */
        public readonly string $banco,
        /**
         * Debit amount in VES (not USD).
         */
        public readonly float $monto,
        /**
         * Payer mobile: 58 + 10 digits, or 0 + 10 digits local form.
         */
        public readonly string $telefono,
        /**
         * Payer cédula/RIF (V/E/J/P/G + digits).
         */
        public readonly string $cedula,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            banco: self::required($data, 'banco'),
            monto: self::required($data, 'monto'),
            telefono: self::required($data, 'telefono'),
            cedula: self::required($data, 'cedula'),
        ))->withRaw($data);
    }
}
