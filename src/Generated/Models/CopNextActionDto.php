<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopNextActionDto extends Model
{
    public function __construct(
        /**
         * `redirect`: send the buyer to `url` to authorize at their bank. `redirect_pending`: the URL is not ready yet — read the payment again. `processing`: nothing to do, the outcome follows.
         */
        public readonly CopNextActionDtoType|string $type,
        /**
         * Bre-B: base64 PNG of the payment QR. Returned only when the payment is created.
         */
        public readonly ?string $qrPngBase64 = null,
        /**
         * Bancolombia QR: base64 SVG of the payment QR.
         */
        public readonly ?string $qrSvgBase64 = null,
        /**
         * `redirect`: where the buyer authorizes the payment.
         */
        public readonly ?string $url = null,
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
            qrSvgBase64: $data['qrSvgBase64'] ?? null,
            url: $data['url'] ?? null,
            transferKey: $data['transferKey'] ?? null,
            phoneMasked: $data['phoneMasked'] ?? null,
        ))->withRaw($data);
    }
}
