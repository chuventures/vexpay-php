<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class AccountCreditDto extends Model
{
    public function __construct(
        /**
         * Account holder cédula/RIF.
         */
        public readonly string $cedula,
        /**
         * 20-digit Venezuelan bank account number.
         */
        public readonly string $cuenta,
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
            cedula: self::required($data, 'cedula'),
            cuenta: self::required($data, 'cuenta'),
            monto: self::required($data, 'monto'),
            concepto: self::required($data, 'concepto'),
        ))->withRaw($data);
    }
}
