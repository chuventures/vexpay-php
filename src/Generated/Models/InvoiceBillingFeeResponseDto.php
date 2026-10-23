<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class InvoiceBillingFeeResponseDto extends Model
{
    public function __construct(
        public readonly string $amount,
        public readonly InvoiceBillingFeeResponseDtoCurrency|string $currency,
        public readonly string $percent,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amount: self::required($data, 'amount'),
            currency: self::enumOrRaw(InvoiceBillingFeeResponseDtoCurrency::class, self::required($data, 'currency')),
            percent: self::required($data, 'percent'),
        ))->withRaw($data);
    }
}
