<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentMethodResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $type,
        public readonly string $customer,
        /**
         * pending until a charge succeeds; inactive when the bank reports the affiliation inactive.
         */
        public readonly PaymentMethodResponseDtoStatus|string $status,
        public readonly string $phoneLast4,
        public readonly string $bankCode,
        public readonly string $createdAt,
        public readonly bool $livemode,
        public readonly ?string $activatedAt = null,
        public readonly ?string $deactivatedAt = null,
        /**
         * Set once detached; a detached method is never charged.
         */
        public readonly ?string $detachedAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            object: self::required($data, 'object'),
            type: self::required($data, 'type'),
            customer: self::required($data, 'customer'),
            status: self::enumOrRaw(PaymentMethodResponseDtoStatus::class, self::required($data, 'status')),
            phoneLast4: self::required($data, 'phoneLast4'),
            bankCode: self::required($data, 'bankCode'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            activatedAt: $data['activatedAt'] ?? null,
            deactivatedAt: $data['deactivatedAt'] ?? null,
            detachedAt: $data['detachedAt'] ?? null,
        ))->withRaw($data);
    }
}
