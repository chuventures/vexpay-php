<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateConversionDto extends Model
{
    public function __construct(
        /**
         * A live quote from `POST /v1/conversions/quotes`. Each quote can be used once.
         */
        public readonly string $quoteId,
        /**
         * Your reference, echoed on the conversion and its webhooks.
         */
        public readonly ?string $reference = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            quoteId: self::required($data, 'quoteId'),
            reference: $data['reference'] ?? null,
        ))->withRaw($data);
    }
}
