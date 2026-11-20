<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopChannelDto extends Model
{
    public function __construct(
        public readonly CopChannelDtoChannel|string $channel,
        /**
         * Buyer-facing name (Spanish).
         */
        public readonly string $label,
        /**
         * A `buyer` object is required.
         */
        public readonly bool $needsBuyer,
        public readonly float $minAmountCop,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            channel: self::enumOrRaw(CopChannelDtoChannel::class, self::required($data, 'channel')),
            label: self::required($data, 'label'),
            needsBuyer: self::required($data, 'needsBuyer'),
            minAmountCop: self::required($data, 'minAmountCop'),
        ))->withRaw($data);
    }
}
