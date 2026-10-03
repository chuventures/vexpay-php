<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantAuditEventDto extends Model
{
    public function __construct(
        public readonly string $id,
        /**
         * SCREAMING_SNAKE lifecycle event, e.g. MERCHANT_CREATED | MERCHANT_ACTIVATED | RIF_SUBMITTED | CAPABILITY_ENABLED | MERCHANT_UPDATED | MERCHANT_RESTRICTED.
         */
        public readonly string $event,
        /**
         * "wallet:<sub>" | "system" | "platform:<sub>".
         */
        public readonly string $actor,
        public readonly string $createdAt,
        /**
         * Event-specific detail, e.g. { fields: ["instagram"] }.
         *
         * @var array<string, mixed>|null
         */
        public readonly ?array $data = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            event: self::required($data, 'event'),
            actor: self::required($data, 'actor'),
            createdAt: self::required($data, 'createdAt'),
            data: $data['data'] ?? null,
        ))->withRaw($data);
    }
}
