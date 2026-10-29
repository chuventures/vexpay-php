<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopTermsDto extends Model
{
    public function __construct(
        /**
         * Terms and conditions the buyer accepts.
         */
        public readonly string $termsUrl,
        /**
         * Personal data processing authorization the buyer accepts.
         */
        public readonly string $personalDataUrl,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            termsUrl: self::required($data, 'termsUrl'),
            personalDataUrl: self::required($data, 'personalDataUrl'),
        ))->withRaw($data);
    }
}
