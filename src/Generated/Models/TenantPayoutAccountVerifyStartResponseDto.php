<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TenantPayoutAccountVerifyStartResponseDto extends Model
{
    public function __construct(
        public readonly TenantPayoutAccountVerifyStartResponseDtoStatus|string $status,
        public readonly string $expiresAt,
        public readonly string $accountId,
        /**
         * Test mode only: the two sandbox micro-deposit amounts to confirm (no money is sent in Test). Never present in live mode.
         *
         * @var list<string>|null
         */
        public readonly ?array $testAmounts = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            status: self::enumOrRaw(TenantPayoutAccountVerifyStartResponseDtoStatus::class, self::required($data, 'status')),
            expiresAt: self::required($data, 'expiresAt'),
            accountId: self::required($data, 'accountId'),
            testAmounts: $data['testAmounts'] ?? null,
        ))->withRaw($data);
    }
}
