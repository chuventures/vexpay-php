<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreatePriceDto extends Model
{
    public function __construct(
        /**
         * Product id.
         */
        public readonly string $product,
        /**
         * USD amount, up to 2 decimals, at least the minimum charge.
         */
        public readonly float $unitAmountUsd,
        public readonly RecurringDto $recurring,
        public readonly ?string $nickname = null,
        /**
         * @var array<string, string>|null
         */
        public readonly ?array $metadata = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            product: self::required($data, 'product'),
            unitAmountUsd: self::required($data, 'unitAmountUsd'),
            recurring: RecurringDto::fromArray(self::required($data, 'recurring')),
            nickname: $data['nickname'] ?? null,
            metadata: $data['metadata'] ?? null,
        ))->withRaw($data);
    }
}
