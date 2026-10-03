<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantListResponseDto extends Model
{
    public function __construct(
        /**
         * @var list<MerchantResponseDto>
         */
        public readonly array $items,
        /**
         * Pass as cursor on the next request when more pages exist
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
            items: self::listOf(MerchantResponseDto::class, self::required($data, 'items')),
            nextCursor: $data['nextCursor'] ?? null,
        ))->withRaw($data);
    }
}
