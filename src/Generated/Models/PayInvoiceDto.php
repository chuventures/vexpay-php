<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayInvoiceDto extends Model
{
    public function __construct(
        /**
         * Mark the invoice paid outside VEXPay (cash, transfer). No balance change.
         */
        public readonly bool $paidOutOfBand,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            paidOutOfBand: self::required($data, 'paidOutOfBand'),
        ))->withRaw($data);
    }
}
