<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreditDisbursementResponseDto extends Model
{
    public function __construct(
        /**
         * Id of the completed PAGO_MOVIL payment that funded this disbursement.
         */
        public readonly string $paymentId,
        /**
         * Normalized bank reference used to locate the inbound payment.
         */
        public readonly string $referencia,
        /**
         * Per-recipient credit results in request order.
         *
         * @var list<array<string, mixed>>
         */
        public readonly array $credits,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            paymentId: self::required($data, 'paymentId'),
            referencia: self::required($data, 'referencia'),
            credits: self::required($data, 'credits'),
        ))->withRaw($data);
    }
}
