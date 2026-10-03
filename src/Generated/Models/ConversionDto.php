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
        public readonly string $sourceAmountVes,
        public readonly string $targetAmountUsdt,
        public readonly string $createdAt,
        public readonly ?string $reference = null,
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
            sourceAmountVes: self::required($data, 'sourceAmountVes'),
            targetAmountUsdt: self::required($data, 'targetAmountUsdt'),
            createdAt: self::required($data, 'createdAt'),
            reference: $data['reference'] ?? null,
            completedAt: $data['completedAt'] ?? null,
            canceledAt: $data['canceledAt'] ?? null,
            cancelReason: $data['cancelReason'] ?? null,
        ))->withRaw($data);
    }
}
