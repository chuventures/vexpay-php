<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpsertTenantPayoutAccountDto extends Model
{
    public function __construct(
        /**
         * Beneficiary (account holder) cédula/RIF.
         */
        public readonly string $cedula,
        /**
         * `pago_movil` (bank + phone) or `bank_account` (20-digit checking account). Switching type is a destination change.
         */
        public readonly UpsertTenantPayoutAccountDtoType|string|null $type = null,
        /**
         * Beneficiary bank SIMF code (3–4 digits). Prefer codes from GET /v1/banks. Required for `pago_movil`; for `bank_account` it is taken from the account number and, when sent, must match its first 4 digits.
         */
        public readonly ?string $banco = null,
        /**
         * Beneficiary Pago Móvil phone (58… or 0…). Required for `pago_movil`.
         */
        public readonly ?string $telefono = null,
        /**
         * 20-digit checking account number. Required for `bank_account`.
         */
        public readonly ?string $cuenta = null,
        /**
         * Account holder name. Required for `bank_account`.
         */
        public readonly ?string $titular = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            cedula: self::required($data, 'cedula'),
            type: isset($data['type']) ? self::enumOrRaw(UpsertTenantPayoutAccountDtoType::class, $data['type']) : null,
            banco: $data['banco'] ?? null,
            telefono: $data['telefono'] ?? null,
            cuenta: $data['cuenta'] ?? null,
            titular: $data['titular'] ?? null,
        ))->withRaw($data);
    }
}
