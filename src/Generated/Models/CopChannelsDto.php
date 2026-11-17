<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopChannelsDto extends Model
{
    public function __construct(
        /**
         * @var list<CopChannelDto>
         */
        public readonly array $channels,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            channels: self::listOf(CopChannelDto::class, self::required($data, 'channels')),
        ))->withRaw($data);
    }
}
