<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PagoMovilReceivingAccountDto extends Model
{
    public function __construct(
        /**
         * Provider Pago Móvil verify uses for this tenant (same routing as POST /v1/payments/pago-movil/verify).
         */
        public readonly PagoMovilReceivingAccountDtoProvider|string $provider,
        /**
         * Four-digit SIMF code of the receiving bank.
         */
        public readonly string $bankCode,
        public readonly string $bankName,
        /**
         * True when every receiving detail is set. Do not offer Pago Móvil to customers while false.
         */
        public readonly bool $configured,
        /**
         * Receiving details that are not configured yet.
         *
         * @var list<PagoMovilReceivingAccountDtoMissing|string>
         */
        public readonly array $missing,
        /**
         * False for test-mode API keys.
         */
        public readonly bool $livemode,
        /**
         * Phone the customer sends the Pago Móvil to (11 digits). Null when not configured.
         */
        public readonly ?string $phone = null,
        /**
         * Cédula/RIF of the receiving account, as configured. Null when not configured.
         */
        public readonly ?string $identification = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            provider: self::enumOrRaw(PagoMovilReceivingAccountDtoProvider::class, self::required($data, 'provider')),
            bankCode: self::required($data, 'bankCode'),
            bankName: self::required($data, 'bankName'),
            configured: self::required($data, 'configured'),
            missing: array_map(static fn ($item) => self::enumOrRaw(PagoMovilReceivingAccountDtoMissing::class, $item), self::required($data, 'missing')),
            livemode: self::required($data, 'livemode'),
            phone: $data['phone'] ?? null,
            identification: $data['identification'] ?? null,
        ))->withRaw($data);
    }
}
