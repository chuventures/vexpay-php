<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class VerifyStartResponseDto extends Model
{
    public function __construct(
        public readonly string $status,
        public readonly string $expiresAt,
        public readonly ?string $payoutMethodId = null,
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
            status: self::required($data, 'status'),
            expiresAt: self::required($data, 'expiresAt'),
            payoutMethodId: $data['payoutMethodId'] ?? null,
            testAmounts: $data['testAmounts'] ?? null,
        ))->withRaw($data);
    }
}
