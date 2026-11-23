<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class RotateWebhookSecretResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        /**
         * The new signing secret. Shown only in this response; store it securely.
         */
        public readonly string $secret,
        /**
         * Until when the previous secret also signs deliveries (a second `v1=` entry). Null when it stopped at once.
         */
        public readonly ?string $previousSecretExpiresAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            secret: self::required($data, 'secret'),
            previousSecretExpiresAt: $data['previousSecretExpiresAt'] ?? null,
        ))->withRaw($data);
    }
}
