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
         * Required for every channel except `breb`.
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
         * National document number. Required for every channel except `breb`.
         */
        public readonly ?string $documentNumber = null,
        /**
         * PSE only (required): `natural` person or `juridica` (company).
         */
        public readonly CopBuyerDtoPersonType|string|null $personType = null,
        /**
         * Required (`true`) for channels the channel catalog marks `needsTermsAcceptance`: confirms you showed the buyer the catalog `terms` links.
         */
        public readonly ?bool $termsAccepted = null,
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
            personType: isset($data['personType']) ? self::enumOrRaw(CopBuyerDtoPersonType::class, $data['personType']) : null,
            termsAccepted: $data['termsAccepted'] ?? null,
        ))->withRaw($data);
    }
}
