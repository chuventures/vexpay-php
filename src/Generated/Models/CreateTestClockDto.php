<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateTestClockDto extends Model
{
    public function __construct(
        /**
         * ISO 8601 time the clock starts at.
         */
        public readonly string $frozenTime,
        public readonly ?string $name = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            frozenTime: self::required($data, 'frozenTime'),
            name: $data['name'] ?? null,
        ))->withRaw($data);
    }
}
