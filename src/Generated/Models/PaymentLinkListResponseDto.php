<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentLinkListResponseDto extends Model
{
    public function __construct(
        /**
         * @var list<PaymentLinkResponseDto>
         */
        public readonly array $items,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            items: self::listOf(PaymentLinkResponseDto::class, self::required($data, 'items')),
        ))->withRaw($data);
    }
}
