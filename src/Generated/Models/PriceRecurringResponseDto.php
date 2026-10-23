<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PriceRecurringResponseDto extends Model
{
    public function __construct(
        public readonly PriceRecurringResponseDtoInterval|string $interval,
        public readonly float $intervalCount,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            interval: self::enumOrRaw(PriceRecurringResponseDtoInterval::class, self::required($data, 'interval')),
            intervalCount: self::required($data, 'intervalCount'),
        ))->withRaw($data);
    }
}
