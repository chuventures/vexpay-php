<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateConversionQuoteDto extends Model
{
    public function __construct(
        /**
         * VES to spend. Send this or `targetAmountUsdt`, not both.
         */
        public readonly ?string $sourceAmountVes = null,
        /**
         * USDT to receive. Send this or `sourceAmountVes`, not both.
         */
        public readonly ?string $targetAmountUsdt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            sourceAmountVes: $data['sourceAmountVes'] ?? null,
            targetAmountUsdt: $data['targetAmountUsdt'] ?? null,
        ))->withRaw($data);
    }
}
