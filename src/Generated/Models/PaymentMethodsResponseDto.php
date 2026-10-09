<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentMethodsResponseDto extends Model
{
    public function __construct(
        /**
         * false for test keys.
         */
        public readonly bool $livemode,
        /**
         * @var list<PaymentMethodAvailabilityDto>
         */
        public readonly array $methods,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            livemode: self::required($data, 'livemode'),
            methods: self::listOf(PaymentMethodAvailabilityDto::class, self::required($data, 'methods')),
        ))->withRaw($data);
    }
}
