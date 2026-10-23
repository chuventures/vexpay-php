<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdateCustomerDto extends Model
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        /**
         * Venezuelan mobile; stored as 11 digits starting with 04.
         */
        public readonly ?string $phone = null,
        /**
         * Cédula or RIF; stored canonical, e.g. V12345678.
         */
        public readonly ?string $idNumber = null,
        /**
         * 4-digit bank code from GET /v1/banks.
         */
        public readonly ?string $bankCode = null,
        /**
         * ≤ 20 string key/value pairs.
         *
         * @var array<string, string>|null
         */
        public readonly ?array $metadata = null,
        /**
         * Test clock id (test mode only). Not available yet.
         */
        public readonly ?string $testClock = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            idNumber: $data['idNumber'] ?? null,
            bankCode: $data['bankCode'] ?? null,
            metadata: $data['metadata'] ?? null,
            testClock: $data['testClock'] ?? null,
        ))->withRaw($data);
    }
}
