<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CustomerResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly CustomerResponseDtoEmailStatus|string $emailStatus,
        /**
         * @var array<string, string>
         */
        public readonly array $metadata,
        public readonly string $createdAt,
        public readonly bool $livemode,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $idNumber = null,
        public readonly ?string $bankCode = null,
        public readonly ?string $testClock = null,
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
            emailStatus: self::enumOrRaw(CustomerResponseDtoEmailStatus::class, self::required($data, 'emailStatus')),
            metadata: self::required($data, 'metadata'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            idNumber: $data['idNumber'] ?? null,
            bankCode: $data['bankCode'] ?? null,
            testClock: $data['testClock'] ?? null,
        ))->withRaw($data);
    }
}
