<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdateMarketplaceSettingsDto extends Model
{
    public function __construct(
        public readonly ?bool $merchantAutoPayoutDefault = null,
        /**
         * USD with at most two decimals (string or number), 0–100000. null or 0 clears the minimum.
         */
        public readonly ?string $merchantAutoPayoutMinUsd = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            merchantAutoPayoutDefault: $data['merchantAutoPayoutDefault'] ?? null,
            merchantAutoPayoutMinUsd: $data['merchantAutoPayoutMinUsd'] ?? null,
        ))->withRaw($data);
    }
}
