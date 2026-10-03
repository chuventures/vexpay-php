<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TenantPayoutAccountResponseDto extends Model
{
    public function __construct(
        public readonly string $accountId,
        public readonly string $bankCode,
        /**
         * Masked phone, e.g. …5555
         */
        public readonly string $destination,
        public readonly string $identification,
        /**
         * UI/API eligibility state. `cooling` = verified after a destination change, still within the 1 business-day wait. `eligible` = may receive instant credits (first verify unlocks immediately).
         */
        public readonly TenantPayoutAccountResponseDtoEligibility|string $eligibility,
        public readonly TenantPayoutAccountResponseDtoStatus|string $status,
        public readonly ?string $verifiedAt = null,
        /**
         * Instant payouts allowed at/after this timestamp (verifiedAt + 1 business day).
         */
        public readonly ?string $payoutEligibleAt = null,
        public readonly ?string $failureCode = null,
        public readonly ?string $lockedUntil = null,
        /**
         * When the current micro-deposit confirm window expires.
         */
        public readonly ?string $verifyExpiresAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            accountId: self::required($data, 'accountId'),
            bankCode: self::required($data, 'bankCode'),
            destination: self::required($data, 'destination'),
            identification: self::required($data, 'identification'),
            eligibility: self::enumOrRaw(TenantPayoutAccountResponseDtoEligibility::class, self::required($data, 'eligibility')),
            status: self::enumOrRaw(TenantPayoutAccountResponseDtoStatus::class, self::required($data, 'status')),
            verifiedAt: $data['verifiedAt'] ?? null,
            payoutEligibleAt: $data['payoutEligibleAt'] ?? null,
            failureCode: $data['failureCode'] ?? null,
            lockedUntil: $data['lockedUntil'] ?? null,
            verifyExpiresAt: $data['verifyExpiresAt'] ?? null,
        ))->withRaw($data);
    }
}
