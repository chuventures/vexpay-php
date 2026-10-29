<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantStatementDto extends Model
{
    public function __construct(
        public readonly string $merchantId,
        public readonly string $month,
        /**
         * Month start, America/Caracas.
         */
        public readonly string $from,
        /**
         * Month end (exclusive), America/Caracas.
         */
        public readonly string $to,
        public readonly string $openingVes,
        /**
         * openingVes + Σ movements[].amountVes.
         */
        public readonly string $closingVes,
        /**
         * Oldest first.
         *
         * @var list<MerchantMovementDto>
         */
        public readonly array $movements,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            merchantId: self::required($data, 'merchantId'),
            month: self::required($data, 'month'),
            from: self::required($data, 'from'),
            to: self::required($data, 'to'),
            openingVes: self::required($data, 'openingVes'),
            closingVes: self::required($data, 'closingVes'),
            movements: self::listOf(MerchantMovementDto::class, self::required($data, 'movements')),
        ))->withRaw($data);
    }
}
