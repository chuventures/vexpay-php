<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ImmediateDebitDto extends Model
{
    public function __construct(
        /**
         * 3–4 digit bank code (padded to 4 digits when sent to the network). Prefer codes from GET /v1/banks.
         */
        public readonly string $banco,
        /**
         * Debit amount in VES (not USD).
         */
        public readonly float $monto,
        /**
         * Payer mobile: 58 + 10 digits, or 0 + 10 digits local form.
         */
        public readonly string $telefono,
        /**
         * Payer cédula/RIF (V/E/J/P/G + digits).
         */
        public readonly string $cedula,
        /**
         * Payer display name (max 20 chars, truncated for the bank).
         */
        public readonly string $nombre,
        /**
         * OTP the payer bank SMS’d after POST /v1/payments/debit/otp.
         */
        public readonly string $otp,
        /**
         * Statement concept shown to the payer (max 30 chars).
         */
        public readonly string $concepto,
        /**
         * Tenant correlation value for recovery lookup (GET /v1/payments/by-ref/:externalRef). Not an idempotency key.
         */
        public readonly ?string $externalRef = null,
        public readonly ?string $merchantId = null,
        /**
         * Marketplace application fee in VES retained by the platform.
         */
        public readonly ?string $applicationFeeVes = null,
        /**
         * Optional percent of vesAmount used when applicationFeeVes is omitted. When both are omitted and merchantId is set, the merchant's commission (or the tenant default commission) applies.
         */
        public readonly ?float $applicationFeePercent = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            banco: self::required($data, 'banco'),
            monto: self::required($data, 'monto'),
            telefono: self::required($data, 'telefono'),
            cedula: self::required($data, 'cedula'),
            nombre: self::required($data, 'nombre'),
            otp: self::required($data, 'otp'),
            concepto: self::required($data, 'concepto'),
            externalRef: $data['externalRef'] ?? null,
            merchantId: $data['merchantId'] ?? null,
            applicationFeeVes: $data['applicationFeeVes'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
        ))->withRaw($data);
    }
}
