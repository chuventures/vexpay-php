<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateProductDto extends Model
{
    public function __construct(
        public readonly string $name,
        /**
         * Positive USD price, up to 2 decimals.
         */
        public readonly string $priceUsd,
        public readonly ?string $description = null,
        public readonly ?string $imageUrl = null,
        public readonly ?bool $active = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            name: self::required($data, 'name'),
            priceUsd: self::required($data, 'priceUsd'),
            description: $data['description'] ?? null,
            imageUrl: $data['imageUrl'] ?? null,
            active: $data['active'] ?? null,
        ))->withRaw($data);
    }
}
