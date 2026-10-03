<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ProductListResponseDto extends Model
{
    public function __construct(
        /**
         * @var list<ProductResponseDto>
         */
        public readonly array $items,
        /**
         * Pass as ?cursor= for the next page.
         */
        public readonly ?string $nextCursor = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            items: self::listOf(ProductResponseDto::class, self::required($data, 'items')),
            nextCursor: $data['nextCursor'] ?? null,
        ))->withRaw($data);
    }
}
