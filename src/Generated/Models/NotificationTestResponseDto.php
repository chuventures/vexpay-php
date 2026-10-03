<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class NotificationTestResponseDto extends Model
{
    public function __construct(
        public readonly bool $sent,
        public readonly string $event,
        public readonly string $tenantId,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            sent: self::required($data, 'sent'),
            event: self::required($data, 'event'),
            tenantId: self::required($data, 'tenantId'),
        ))->withRaw($data);
    }
}
