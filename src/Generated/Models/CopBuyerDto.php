<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopBuyerDto extends Model
{
    public function __construct(
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        /**
         * Required for Nequi and Daviplata.
         */
        public readonly ?string $email = null,
        /**
         * Colombian mobile number (10 digits starting with 3, with or without +57). Required for Nequi (it receives the push) and Daviplata.
         */
        public readonly ?string $phone = null,
        /**
         * Required for Nequi and Daviplata. Daviplata accepts CC, CE and TI only.
         */
        public readonly CopBuyerDtoDocumentType|string|null $documentType = null,
        /**
         * National document number. Required for Nequi and Daviplata.
         */
        public readonly ?string $documentNumber = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            documentType: isset($data['documentType']) ? self::enumOrRaw(CopBuyerDtoDocumentType::class, $data['documentType']) : null,
            documentNumber: $data['documentNumber'] ?? null,
        ))->withRaw($data);
    }
}
