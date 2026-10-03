<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateWebhookDto extends Model
{
    public function __construct(
        public readonly string $url,
        /**
         * @var list<CreateWebhookDtoEvents|string>
         */
        public readonly array $events,
        /**
         * Signing secret. If omitted, a random secret is generated and returned once.
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
            url: self::required($data, 'url'),
            events: array_map(static fn ($item) => self::enumOrRaw(CreateWebhookDtoEvents::class, $item), self::required($data, 'events')),
            secret: $data['secret'] ?? null,
        ))->withRaw($data);
    }
}
