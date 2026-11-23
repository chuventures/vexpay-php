<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentLinkListDto extends Model
{
    public function __construct(
        /**
         * One-shot (`kind: one_shot`) and product (`kind: product`) links, newest first.
         *
         * @var list<array<string, mixed>>
         */
        public readonly array $items,
        public readonly ?string $nextCursor = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            items: self::required($data, 'items'),
            nextCursor: $data['nextCursor'] ?? null,
        ))->withRaw($data);
    }
}
