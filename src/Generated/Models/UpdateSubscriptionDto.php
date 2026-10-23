<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdateSubscriptionDto extends Model
{
    public function __construct(
        public readonly ?bool $cancelAtPeriodEnd = null,
        public readonly UpdateSubscriptionDtoCollectionMethod|string|null $collectionMethod = null,
        public readonly ?string $paymentMethod = null,
        /**
         * null = the tenant's default.
         */
        public readonly ?float $collectionAttempts = null,
        /**
         * @var list<UpdateSubscriptionDtoMethods|string>|null
         */
        public readonly ?array $methods = null,
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
            cancelAtPeriodEnd: $data['cancelAtPeriodEnd'] ?? null,
            collectionMethod: isset($data['collectionMethod']) ? self::enumOrRaw(UpdateSubscriptionDtoCollectionMethod::class, $data['collectionMethod']) : null,
            paymentMethod: $data['paymentMethod'] ?? null,
            collectionAttempts: $data['collectionAttempts'] ?? null,
            methods: isset($data['methods']) ? array_map(static fn ($item) => self::enumOrRaw(UpdateSubscriptionDtoMethods::class, $item), $data['methods']) : null,
            metadata: $data['metadata'] ?? null,
        ))->withRaw($data);
    }
}
