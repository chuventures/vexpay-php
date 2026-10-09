<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateConversionQuoteDto extends Model
{
    public function __construct(
        /**
         * Currency you convert from. Defaults to `VES`.
         */
        public readonly CreateConversionQuoteDtoSourceCurrency|string|null $sourceCurrency = null,
        /**
         * Amount of `sourceCurrency` to spend (VES: up to 2 decimals; COP: whole pesos). Send this or `targetAmountUsdt`, not both.
         */
        public readonly ?string $sourceAmount = null,
        /**
         * VES only: same as `sourceAmount` (kept for existing integrations).
         */
        public readonly ?string $sourceAmountVes = null,
        /**
         * USDT to receive. Send this or `sourceAmount`, not both.
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
            sourceCurrency: isset($data['sourceCurrency']) ? self::enumOrRaw(CreateConversionQuoteDtoSourceCurrency::class, $data['sourceCurrency']) : null,
            sourceAmount: $data['sourceAmount'] ?? null,
            sourceAmountVes: $data['sourceAmountVes'] ?? null,
            targetAmountUsdt: $data['targetAmountUsdt'] ?? null,
        ))->withRaw($data);
    }
}
