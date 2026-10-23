<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdatePriceDto extends Model
{
    public function __construct(
        public readonly ?bool $active = null,
        public readonly ?string $nickname = null,
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
            active: $data['active'] ?? null,
            nickname: $data['nickname'] ?? null,
            metadata: $data['metadata'] ?? null,
        ))->withRaw($data);
    }
}
