<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayoutMethodResponseDto extends Model
{
    public function __construct(
        public readonly string $payoutMethodId,
        public readonly string $bankCode,
        /**
         * Masked phone destination, e.g. …5555
         */
        public readonly string $destination,
        public readonly PayoutMethodResponseDtoStatus|string $status,
        public readonly bool $isDefault,
        public readonly ?string $failureCode = null,
        public readonly ?string $lockedUntil = null,
        public readonly ?string $verifiedAt = null,
        public readonly ?string $createdAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            payoutMethodId: self::required($data, 'payoutMethodId'),
            bankCode: self::required($data, 'bankCode'),
            destination: self::required($data, 'destination'),
            status: self::enumOrRaw(PayoutMethodResponseDtoStatus::class, self::required($data, 'status')),
            isDefault: self::required($data, 'isDefault'),
            failureCode: $data['failureCode'] ?? null,
            lockedUntil: $data['lockedUntil'] ?? null,
            verifiedAt: $data['verifiedAt'] ?? null,
            createdAt: $data['createdAt'] ?? null,
        ))->withRaw($data);
    }
}
