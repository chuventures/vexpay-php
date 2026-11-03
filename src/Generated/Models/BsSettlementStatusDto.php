<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class BsSettlementStatusDto extends Model
{
    public function __construct(
        /**
         * True when your available Bs is settled automatically every 15 minutes.
         */
        public readonly bool $enabled,
        /**
         * `active` = settling; `no_payout_account` / `payout_account_unverified` = add and verify a payout account; `payout_account_cooling` = destination changed recently; `paused` = paused by VEXPay; `opted_out` = off for your account; `disbursements` = your balance funds disbursements; `test_mode` = never settled in test mode.
         */
        public readonly BsSettlementStatusDtoStatus|string $status,
        /**
         * Smallest available Bs amount that is settled.
         */
        public readonly string $minimumVes,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            enabled: self::required($data, 'enabled'),
            status: self::enumOrRaw(BsSettlementStatusDtoStatus::class, self::required($data, 'status')),
            minimumVes: self::required($data, 'minimumVes'),
        ))->withRaw($data);
    }
}
