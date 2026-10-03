<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class WebhookEndpointDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $tenantId,
        public readonly string $url,
        /**
         * @var list<WebhookEndpointDtoEvents|string>
         */
        public readonly array $events,
        public readonly bool $isActive,
        public readonly string $createdAt,
        /**
         * Returned only when the endpoint is created. Store it securely; list responses omit it.
         */
        public readonly ?string $secret = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            tenantId: self::required($data, 'tenantId'),
            url: self::required($data, 'url'),
            events: array_map(static fn ($item) => self::enumOrRaw(WebhookEndpointDtoEvents::class, $item), self::required($data, 'events')),
            isActive: self::required($data, 'isActive'),
            createdAt: self::required($data, 'createdAt'),
            secret: $data['secret'] ?? null,
        ))->withRaw($data);
    }
}
