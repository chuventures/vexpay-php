<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TenantPayoutAccountVerifyConfirmResponseDto extends Model
{
    public function __construct(
        /**
         * `eligible` on first successful verify (instant credits allowed immediately). `cooling` after a destination change re-verify (1 business day).
         */
        public readonly TenantPayoutAccountVerifyConfirmResponseDtoStatus|string $status,
        public readonly string $accountId,
        public readonly string $payoutEligibleAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            status: self::enumOrRaw(TenantPayoutAccountVerifyConfirmResponseDtoStatus::class, self::required($data, 'status')),
            accountId: self::required($data, 'accountId'),
            payoutEligibleAt: self::required($data, 'payoutEligibleAt'),
        ))->withRaw($data);
    }
}
