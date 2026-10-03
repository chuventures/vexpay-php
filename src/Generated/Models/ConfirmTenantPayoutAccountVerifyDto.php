<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ConfirmTenantPayoutAccountVerifyDto extends Model
{
    public function __construct(
        /**
         * First micro-deposit amount (exact two decimals).
         */
        public readonly string $amount1,
        /**
         * Second micro-deposit amount (exact two decimals).
         */
        public readonly string $amount2,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amount1: self::required($data, 'amount1'),
            amount2: self::required($data, 'amount2'),
        ))->withRaw($data);
    }
}
