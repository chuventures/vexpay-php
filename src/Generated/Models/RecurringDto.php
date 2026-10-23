<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class RecurringDto extends Model
{
    public function __construct(
        public readonly RecurringDtoInterval|string $interval,
        /**
         * The whole interval is at most one year.
         */
        public readonly ?float $intervalCount = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            interval: self::enumOrRaw(RecurringDtoInterval::class, self::required($data, 'interval')),
            intervalCount: $data['intervalCount'] ?? null,
        ))->withRaw($data);
    }
}
