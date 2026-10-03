<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class DepositAddressDto extends Model
{
    public function __construct(
        public readonly string $customerRef,
        public readonly string $network,
        public readonly DepositAddressDtoCurrency|string $currency,
        public readonly string $address,
        /**
         * True when the network requires the tag.
         */
        public readonly bool $tagRequired,
        public readonly string $createdAt,
        /**
         * Destination tag / memo the payer must include (TON).
         */
        public readonly ?string $tag = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            customerRef: self::required($data, 'customerRef'),
            network: self::required($data, 'network'),
            currency: self::enumOrRaw(DepositAddressDtoCurrency::class, self::required($data, 'currency')),
            address: self::required($data, 'address'),
            tagRequired: self::required($data, 'tagRequired'),
            createdAt: self::required($data, 'createdAt'),
            tag: $data['tag'] ?? null,
        ))->withRaw($data);
    }
}
