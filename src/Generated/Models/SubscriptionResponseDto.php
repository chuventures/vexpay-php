<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class SubscriptionResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $customer,
        public readonly PriceResponseDto $price,
        public readonly SubscriptionResponseDtoStatus|string $status,
        public readonly SubscriptionResponseDtoCollectionMethod|string $collectionMethod,
        public readonly string $currentPeriodStart,
        public readonly string $currentPeriodEnd,
        public readonly bool $cancelAtPeriodEnd,
        /**
         * @var list<SubscriptionResponseDtoMethods|string>
         */
        public readonly array $methods,
        /**
         * @var array<string, string>
         */
        public readonly array $metadata,
        public readonly string $createdAt,
        public readonly bool $livemode,
        /**
         * Null = the tenant's default.
         */
        public readonly ?float $collectionAttempts = null,
        public readonly ?string $paymentMethod = null,
        public readonly ?string $trialStart = null,
        public readonly ?string $trialEnd = null,
        public readonly ?string $canceledAt = null,
        public readonly SubscriptionResponseDtoCancellationReason|string|null $cancellationReason = null,
        public readonly ?string $latestInvoice = null,
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
            customer: self::required($data, 'customer'),
            price: PriceResponseDto::fromArray(self::required($data, 'price')),
            status: self::enumOrRaw(SubscriptionResponseDtoStatus::class, self::required($data, 'status')),
            collectionMethod: self::enumOrRaw(SubscriptionResponseDtoCollectionMethod::class, self::required($data, 'collectionMethod')),
            currentPeriodStart: self::required($data, 'currentPeriodStart'),
            currentPeriodEnd: self::required($data, 'currentPeriodEnd'),
            cancelAtPeriodEnd: self::required($data, 'cancelAtPeriodEnd'),
            methods: array_map(static fn ($item) => self::enumOrRaw(SubscriptionResponseDtoMethods::class, $item), self::required($data, 'methods')),
            metadata: self::required($data, 'metadata'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            collectionAttempts: $data['collectionAttempts'] ?? null,
            paymentMethod: $data['paymentMethod'] ?? null,
            trialStart: $data['trialStart'] ?? null,
            trialEnd: $data['trialEnd'] ?? null,
            canceledAt: $data['canceledAt'] ?? null,
            cancellationReason: isset($data['cancellationReason']) ? self::enumOrRaw(SubscriptionResponseDtoCancellationReason::class, $data['cancellationReason']) : null,
            latestInvoice: $data['latestInvoice'] ?? null,
        ))->withRaw($data);
    }
}
