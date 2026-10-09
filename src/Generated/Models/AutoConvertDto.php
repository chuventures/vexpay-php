<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class AutoConvertDto extends Model
{
    public function __construct(
        public readonly AutoConvertPercentDto $COP,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            COP: AutoConvertPercentDto::fromArray(self::required($data, 'COP')),
        ))->withRaw($data);
    }
}
