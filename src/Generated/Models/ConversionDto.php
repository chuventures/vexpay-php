<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ConversionDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly ConversionDtoStatus|string $status,
        public readonly string $rate,
        public readonly string $marketRate,
        public readonly string $spreadPercent,
        public readonly ConversionDtoRateSource|string $rateSource,
        public readonly ConversionDtoSourceCurrency|string $sourceCurrency,
        /**
         * Amount debited (VES to the cent, COP in whole pesos).
         */
        public readonly string $sourceAmount,
        public readonly string $targetAmountUsdt,
        /**
         * `auto` when created by auto-convert from a pay-in.
         */
        public readonly ConversionDtoOrigin|string $origin,
        public readonly string $createdAt,
        public readonly ?string $reference = null,
        /**
         * VES conversions only; `null` for COP.
         */
        public readonly ?string $sourceAmountVes = null,
        /**
         * The pay-in an auto-conversion came from; `null` otherwise.
         */
        public readonly ?string $paymentId = null,
        public readonly ?string $completedAt = null,
        public readonly ?string $canceledAt = null,
        public readonly ?string $cancelReason = null,
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
            status: self::enumOrRaw(ConversionDtoStatus::class, self::required($data, 'status')),
            rate: self::required($data, 'rate'),
            marketRate: self::required($data, 'marketRate'),
            spreadPercent: self::required($data, 'spreadPercent'),
            rateSource: self::enumOrRaw(ConversionDtoRateSource::class, self::required($data, 'rateSource')),
            sourceCurrency: self::enumOrRaw(ConversionDtoSourceCurrency::class, self::required($data, 'sourceCurrency')),
            sourceAmount: self::required($data, 'sourceAmount'),
            targetAmountUsdt: self::required($data, 'targetAmountUsdt'),
            origin: self::enumOrRaw(ConversionDtoOrigin::class, self::required($data, 'origin')),
            createdAt: self::required($data, 'createdAt'),
            reference: $data['reference'] ?? null,
            sourceAmountVes: $data['sourceAmountVes'] ?? null,
            paymentId: $data['paymentId'] ?? null,
            completedAt: $data['completedAt'] ?? null,
            canceledAt: $data['canceledAt'] ?? null,
            cancelReason: $data['cancelReason'] ?? null,
        ))->withRaw($data);
    }
}
