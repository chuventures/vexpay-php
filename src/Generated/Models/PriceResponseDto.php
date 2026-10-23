<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PriceResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $product,
        public readonly string $unitAmountUsd,
        public readonly string $currency,
        public readonly PriceRecurringResponseDto $recurring,
        public readonly bool $active,
        /**
         * @var array<string, string>
         */
        public readonly array $metadata,
        public readonly string $createdAt,
        public readonly bool $livemode,
        public readonly ?string $nickname = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            object: self::required($data, 'object'),
            product: self::required($data, 'product'),
            unitAmountUsd: self::required($data, 'unitAmountUsd'),
            currency: self::required($data, 'currency'),
            recurring: PriceRecurringResponseDto::fromArray(self::required($data, 'recurring')),
            active: self::required($data, 'active'),
            metadata: self::required($data, 'metadata'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            nickname: $data['nickname'] ?? null,
        ))->withRaw($data);
    }
}
