<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ConversionQuoteDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        /**
         * VES per 1 USDT you get: market rate plus your spread.
         */
        public readonly string $rate,
        /**
         * Market USDT/VES rate the quote is based on.
         */
        public readonly string $marketRate,
        /**
         * Your spread, in percent.
         */
        public readonly string $spreadPercent,
        public readonly ConversionQuoteDtoRateSource|string $rateSource,
        public readonly string $sourceAmountVes,
        /**
         * Rounded down to the cent.
         */
        public readonly string $targetAmountUsdt,
        /**
         * The quote can be accepted until this time (60 seconds).
         */
        public readonly string $expiresAt,
        public readonly string $createdAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            object: self::required($data, 'object'),
            rate: self::required($data, 'rate'),
            marketRate: self::required($data, 'marketRate'),
            spreadPercent: self::required($data, 'spreadPercent'),
            rateSource: self::enumOrRaw(ConversionQuoteDtoRateSource::class, self::required($data, 'rateSource')),
            sourceAmountVes: self::required($data, 'sourceAmountVes'),
            targetAmountUsdt: self::required($data, 'targetAmountUsdt'),
            expiresAt: self::required($data, 'expiresAt'),
            createdAt: self::required($data, 'createdAt'),
        ))->withRaw($data);
    }
}
