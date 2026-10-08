<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class SubmitCopOtpDto extends Model
{
    public function __construct(
        /**
         * The code the buyer received by SMS.
         */
        public readonly string $otp,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            otp: self::required($data, 'otp'),
        ))->withRaw($data);
    }
}
