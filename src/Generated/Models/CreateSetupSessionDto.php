<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateSetupSessionDto extends Model
{
    public function __construct(
        /**
         * Customer id (cus_…).
         */
        public readonly string $customer,
        /**
         * Where the setup page sends the customer when done (https).
         */
        public readonly ?string $successUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            customer: self::required($data, 'customer'),
            successUrl: $data['successUrl'] ?? null,
        ))->withRaw($data);
    }
}
