<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class AdvanceTestClockDto extends Model
{
    public function __construct(
        /**
         * ISO 8601 time to move to: later than the current one, and at most two intervals of the shortest subscription on the clock ahead.
         */
        public readonly string $frozenTime,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            frozenTime: self::required($data, 'frozenTime'),
        ))->withRaw($data);
    }
}
