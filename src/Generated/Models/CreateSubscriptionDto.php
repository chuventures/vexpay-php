<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateSubscriptionDto extends Model
{
    public function __construct(
        /**
         * Customer id (cus_…).
         */
        public readonly string $customer,
        /**
         * Active recurring price id (price_…).
         */
        public readonly string $price,
        /**
         * `charge_automatically` charges the customer's domiciliación on each collection attempt; the tenant must be allowed domiciliación.
         */
        public readonly CreateSubscriptionDtoCollectionMethod|string|null $collectionMethod = null,
        /**
         * Daily collection attempts on each invoice before the subscription is canceled. Omit or null for the tenant's default (3 unless changed).
         */
        public readonly ?float $collectionAttempts = null,
        /**
         * Domiciliación payment method (pm_…, charge_automatically only). Default: the customer's most recent method that is not inactive.
         */
        public readonly ?string $paymentMethod = null,
        public readonly ?float $trialPeriodDays = null,
        /**
         * ISO time in the future when the trial ends.
         */
        public readonly ?string $trialEnd = null,
        public readonly ?bool $cancelAtPeriodEnd = null,
        /**
         * Hosted checkout methods offered on its invoices.
         *
         * @var list<CreateSubscriptionDtoMethods|string>|null
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
            customer: self::required($data, 'customer'),
            price: self::required($data, 'price'),
            collectionMethod: isset($data['collectionMethod']) ? self::enumOrRaw(CreateSubscriptionDtoCollectionMethod::class, $data['collectionMethod']) : null,
            collectionAttempts: $data['collectionAttempts'] ?? null,
            paymentMethod: $data['paymentMethod'] ?? null,
            trialPeriodDays: $data['trialPeriodDays'] ?? null,
            trialEnd: $data['trialEnd'] ?? null,
            cancelAtPeriodEnd: $data['cancelAtPeriodEnd'] ?? null,
            methods: isset($data['methods']) ? array_map(static fn ($item) => self::enumOrRaw(CreateSubscriptionDtoMethods::class, $item), $data['methods']) : null,
            metadata: $data['metadata'] ?? null,
        ))->withRaw($data);
    }
}
