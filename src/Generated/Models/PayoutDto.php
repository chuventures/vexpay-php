<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayoutDto extends Model
{
    public function __construct(
        /**
         * Total VES amount across all personas.
         */
        public readonly float $monto,
        /**
         * Value date as MM/DD/YYYY.
         */
        public readonly string $fecha,
        /**
         * Numeric reference (digits only). Only the last 9 digits are sent to the bank network.
         */
        public readonly string $referencia,
        /**
         * Account beneficiaries. Sum of personas[].montoPart must equal monto.
         *
         * @var list<PayoutRecipientDto>
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
            fecha: self::required($data, 'fecha'),
            referencia: self::required($data, 'referencia'),
            personas: self::listOf(PayoutRecipientDto::class, self::required($data, 'personas')),
        ))->withRaw($data);
    }
}
