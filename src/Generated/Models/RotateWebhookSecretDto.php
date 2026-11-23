<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class RotateWebhookSecretDto extends Model
{
    public function __construct(
        /**
         * Hours the previous secret keeps signing (a second `v1=` entry) so you can switch without missing deliveries. 0 stops it at once (use after a leak).
         */
        public readonly ?float $expiresInHours = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            expiresInHours: $data['expiresInHours'] ?? null,
        ))->withRaw($data);
    }
}
