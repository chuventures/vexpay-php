<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class QuoteResponseDto extends Model
{
    public function __construct(
        public readonly float $usdAmount,
        /**
         * Authoritative VEX FX BCV rate used for payment settlement
         */
        public readonly float $bcvRate,
        public readonly float $vesAmount,
        /**
         * Median of available BCV sources (VEX FX + bank)
         */
        public readonly float $medianRate,
        /**
         * USD amount converted at medianRate
         */
        public readonly float $medianVesAmount,
        public readonly string $source,
        public readonly string $fetchedAt,
        /**
         * Per-source BCV rates or error objects (e.g. `{ error: "BANK_NOT_CONFIGURED" }`). Keys typically include `vexFx` and `bank`. `sources.bank` is the partner-bank BCV rate when available.
         *
         * @var array<string, mixed>
         */
        public readonly array $sources,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            usdAmount: self::required($data, 'usdAmount'),
            bcvRate: self::required($data, 'bcvRate'),
            vesAmount: self::required($data, 'vesAmount'),
            medianRate: self::required($data, 'medianRate'),
            medianVesAmount: self::required($data, 'medianVesAmount'),
            source: self::required($data, 'source'),
            fetchedAt: self::required($data, 'fetchedAt'),
            sources: self::required($data, 'sources'),
        ))->withRaw($data);
    }
}
