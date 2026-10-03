<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdateProductDto extends Model
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $imageUrl = null,
        public readonly ?string $priceUsd = null,
        public readonly ?bool $active = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            imageUrl: $data['imageUrl'] ?? null,
            priceUsd: $data['priceUsd'] ?? null,
            active: $data['active'] ?? null,
        ))->withRaw($data);
    }
}
