<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopNextActionDto extends Model
{
    public function __construct(
        /**
         * `show_qr`: Bre-B QR / transfer key. `approve_in_app`: the buyer approves the Nequi push. `submit_otp`: send the Daviplata SMS code.
         */
        public readonly CopNextActionDtoType|string $type,
        /**
         * Bre-B: base64 PNG of the payment QR. Returned only when the payment is created.
         */
        public readonly ?string $qrPngBase64 = null,
        /**
         * Bre-B: transfer key the buyer can enter instead of scanning.
         */
        public readonly ?string $transferKey = null,
        /**
         * Nequi: masked phone that received the push.
         */
        public readonly ?string $phoneMasked = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            type: self::enumOrRaw(CopNextActionDtoType::class, self::required($data, 'type')),
            qrPngBase64: $data['qrPngBase64'] ?? null,
            transferKey: $data['transferKey'] ?? null,
            phoneMasked: $data['phoneMasked'] ?? null,
        ))->withRaw($data);
    }
}
