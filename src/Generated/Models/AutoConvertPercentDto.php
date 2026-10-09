<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class AutoConvertPercentDto extends Model
{
    public function __construct(
        /**
         * Whole number; 0 = off.
         */
        public readonly int $percent,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            percent: self::required($data, 'percent'),
        ))->withRaw($data);
    }
}
