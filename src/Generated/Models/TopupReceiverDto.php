<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TopupReceiverDto extends Model
{
    public function __construct(
        /**
         * Bank code to pick in your bank app. The bank name is not shown.
         */
        public readonly string $bankCode,
        public readonly string $phone,
        public readonly string $identification,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            bankCode: self::required($data, 'bankCode'),
            phone: self::required($data, 'phone'),
            identification: self::required($data, 'identification'),
        ))->withRaw($data);
    }
}
