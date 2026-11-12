<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MarketplaceSettingsDto extends Model
{
    public function __construct(
        /**
         * When true, merchants you create without `autoPayoutEnabled` start with auto-payout on. Existing merchants keep their setting.
         */
        public readonly bool $merchantAutoPayoutDefault,
        /**
         * Smallest available balance, in USD at the BCV rate, that an automatic merchant payout sends. null = no minimum (any balance of Bs 1 or more).
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
            merchantAutoPayoutDefault: self::required($data, 'merchantAutoPayoutDefault'),
            merchantAutoPayoutMinUsd: $data['merchantAutoPayoutMinUsd'] ?? null,
        ))->withRaw($data);
    }
}
