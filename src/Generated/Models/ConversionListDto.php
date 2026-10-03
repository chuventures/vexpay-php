<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ConversionListDto extends Model
{
    public function __construct(
        /**
         * @var list<ConversionDto>
         */
        public readonly array $items,
        /**
         * Pass as `cursor` to get the next page.
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
            items: self::listOf(ConversionDto::class, self::required($data, 'items')),
            nextCursor: $data['nextCursor'] ?? null,
        ))->withRaw($data);
    }
}
