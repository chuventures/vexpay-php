<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PaymentMethodAvailabilityDto extends Model
{
    public function __construct(
        /**
         * `pago_movil`: the customer sends a Pago Móvil (verify). `c2p`: bank debit with the customer's OTP. `vpos`: card.
         */
        public readonly PaymentMethodAvailabilityDtoMethod|string $method,
        /**
         * Whether your account can take this method right now.
         */
        public readonly bool $available,
        /**
         * Only when available is false. `not_enabled`: the method is not enabled on your account. `receiving_account_not_configured`: Pago Móvil receiving details are not set up yet. `provider_not_configured`: temporarily unavailable in this mode — contact support.
         */
        public readonly PaymentMethodAvailabilityDtoReason|string|null $reason = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            method: self::enumOrRaw(PaymentMethodAvailabilityDtoMethod::class, self::required($data, 'method')),
            available: self::required($data, 'available'),
            reason: isset($data['reason']) ? self::enumOrRaw(PaymentMethodAvailabilityDtoReason::class, $data['reason']) : null,
        ))->withRaw($data);
    }
}
