<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentLinkResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        /**
         * Product links are reusable; one-shot links have kind `one_shot`.
         */
        public readonly PaymentLinkResponseDtoKind|string $kind,
        public readonly string $productId,
        public readonly string $slug,
        /**
         * Path of the hosted checkout page.
         */
        public readonly string $hostedCheckoutPath,
        public readonly PaymentLinkResponseDtoStatus|string $status,
        public readonly bool $allowQuantity,
        public readonly string $createdAt,
        public readonly ?float $maxQuantity = null,
        public readonly ?string $redirectUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            kind: self::enumOrRaw(PaymentLinkResponseDtoKind::class, self::required($data, 'kind')),
            productId: self::required($data, 'productId'),
            slug: self::required($data, 'slug'),
            hostedCheckoutPath: self::required($data, 'hostedCheckoutPath'),
            status: self::enumOrRaw(PaymentLinkResponseDtoStatus::class, self::required($data, 'status')),
            allowQuantity: self::required($data, 'allowQuantity'),
            createdAt: self::required($data, 'createdAt'),
            maxQuantity: $data['maxQuantity'] ?? null,
            redirectUrl: $data['redirectUrl'] ?? null,
        ))->withRaw($data);
    }
}
