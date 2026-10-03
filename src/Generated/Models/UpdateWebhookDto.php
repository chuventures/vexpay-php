<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdateWebhookDto extends Model
{
    public function __construct(
        public readonly ?string $url = null,
        /**
         * Replaces the full event subscription list when provided.
         *
         * @var list<UpdateWebhookDtoEvents|string>|null
         */
        public readonly ?array $events = null,
        public readonly ?bool $isActive = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            url: $data['url'] ?? null,
            events: isset($data['events']) ? array_map(static fn ($item) => self::enumOrRaw(UpdateWebhookDtoEvents::class, $item), $data['events']) : null,
            isActive: $data['isActive'] ?? null,
        ))->withRaw($data);
    }
}
