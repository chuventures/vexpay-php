<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ChangePaymentDto extends Model
{
    public function __construct(
        /**
         * Customer phone that receives the change (vuelto).
         */
        public readonly string $telefonoDestino,
        /**
         * Customer cédula/RIF.
         */
        public readonly string $cedula,
        /**
         * Customer bank code (3–4 digits).
         */
        public readonly string $banco,
        /**
         * Change amount in VES.
         */
        public readonly float $monto,
        /**
         * Optional statement concept (max 30 chars).
         */
        public readonly ?string $concepto = null,
        /**
         * Client IP recorded with the operation. Defaults to R4_DEFAULT_CLIENT_IP when omitted.
         */
        public readonly ?string $ip = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            telefonoDestino: self::required($data, 'telefonoDestino'),
            cedula: self::required($data, 'cedula'),
            banco: self::required($data, 'banco'),
            monto: self::required($data, 'monto'),
            concepto: $data['concepto'] ?? null,
            ip: $data['ip'] ?? null,
        ))->withRaw($data);
    }
}
