<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class OnwardPayoutDto extends Model
{
    public function __construct(
        /**
         * USDT payout network (see GET /v1/crypto/networks).
         */
        public readonly string $network,
        /**
         * Destination wallet address. Only its format is checked: a wrong but valid address cannot be recovered.
         */
        public readonly string $address,
        /**
         * Destination tag / memo, for networks that need one (e.g. TON).
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
            network: self::required($data, 'network'),
            address: self::required($data, 'address'),
            tag: $data['tag'] ?? null,
        ))->withRaw($data);
    }
}
