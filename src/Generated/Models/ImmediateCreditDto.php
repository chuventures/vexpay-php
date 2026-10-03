<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ImmediateCreditDto extends Model
{
    public function __construct(
        /**
         * Beneficiary bank code (3–4 digits). Prefer codes from GET /v1/banks.
         */
        public readonly string $banco,
        /**
         * Beneficiary cédula/RIF.
         */
        public readonly string $cedula,
        /**
         * Beneficiary Pago Móvil phone (58… or 0…).
         */
        public readonly string $telefono,
        /**
         * Credit amount in VES.
         */
        public readonly float $monto,
        /**
         * Statement concept (max 30 chars).
         */
        public readonly string $concepto,
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
            monto: self::required($data, 'monto'),
            concepto: self::required($data, 'concepto'),
        ))->withRaw($data);
    }
}
