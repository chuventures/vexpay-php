<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class DeleteWebhookResponseDto extends Model
{
    public function __construct(
        public readonly bool $deleted,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            deleted: self::required($data, 'deleted'),
        ))->withRaw($data);
    }
}
