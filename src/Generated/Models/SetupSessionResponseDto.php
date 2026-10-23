<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class SetupSessionResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $customer,
        public readonly SetupSessionResponseDtoStatus|string $status,
        public readonly string $expiresAt,
        public readonly string $createdAt,
        public readonly bool $livemode,
        /**
         * Hosted authorization page. Only returned on create.
         */
        public readonly ?string $url = null,
        public readonly ?string $paymentMethod = null,
        public readonly ?string $successUrl = null,
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
            customer: self::required($data, 'customer'),
            status: self::enumOrRaw(SetupSessionResponseDtoStatus::class, self::required($data, 'status')),
            expiresAt: self::required($data, 'expiresAt'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            url: $data['url'] ?? null,
            paymentMethod: $data['paymentMethod'] ?? null,
            successUrl: $data['successUrl'] ?? null,
        ))->withRaw($data);
    }
}
