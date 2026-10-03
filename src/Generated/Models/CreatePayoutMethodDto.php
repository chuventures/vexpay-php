<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreatePayoutMethodDto extends Model
{
    public function __construct(
        /**
         * 4-digit SIMF bank code
         */
        public readonly string $bankCode,
        /**
         * 11-digit local Pago Móvil phone
         */
        public readonly string $phone,
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
        ))->withRaw($data);
    }
}
