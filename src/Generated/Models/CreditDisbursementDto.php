<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreditDisbursementDto extends Model
{
    public function __construct(
        /**
         * Total VES amount to disburse. Must match a completed PAGO_MOVIL payment’s vesAmount for the given referencia.
         */
        public readonly float $monto,
        /**
         * Bank reference of a completed inbound Pago Móvil payment (up to 9 digits). Used to locate and mark that payment as dispersed.
         */
        public readonly string $referencia,
        /**
         * Concept applied to each credit leg.
         */
        public readonly string $concepto,
        /**
         * One or more phone recipients. Sum of personas[].montoPart must equal monto.
         *
         * @var list<CreditRecipientDto>
         */
        public readonly array $personas,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            monto: self::required($data, 'monto'),
            referencia: self::required($data, 'referencia'),
            concepto: self::required($data, 'concepto'),
            personas: self::listOf(CreditRecipientDto::class, self::required($data, 'personas')),
        ))->withRaw($data);
    }
}
