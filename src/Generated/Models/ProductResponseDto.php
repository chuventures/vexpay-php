<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ProductResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $priceUsd,
        public readonly bool $active,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
        public readonly ?string $imageUrl = null,
        /**
         * @var list<PaymentLinkResponseDto>|null
         */
        public readonly ?array $links = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            name: self::required($data, 'name'),
            priceUsd: self::required($data, 'priceUsd'),
            active: self::required($data, 'active'),
            createdAt: self::required($data, 'createdAt'),
            updatedAt: self::required($data, 'updatedAt'),
            description: $data['description'] ?? null,
            imageUrl: $data['imageUrl'] ?? null,
            links: isset($data['links']) ? self::listOf(PaymentLinkResponseDto::class, $data['links']) : null,
        ))->withRaw($data);
    }
}
