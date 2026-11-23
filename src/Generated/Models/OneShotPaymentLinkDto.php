<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class OneShotPaymentLinkDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly OneShotPaymentLinkDtoKind|string $kind,
        /**
         * Where the link was created.
         */
        public readonly OneShotPaymentLinkDtoOrigin|string $origin,
        /**
         * Hosted checkout URL to share with the buyer.
         */
        public readonly string $url,
        public readonly string $slug,
        public readonly OneShotPaymentLinkDtoStatus|string $status,
        public readonly string $amount,
        public readonly OneShotPaymentLinkDtoCurrency|string $currency,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly ?string $reference = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $paidAt = null,
        /**
         * The completed payment, once paid.
         */
        public readonly ?string $paymentId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            kind: self::enumOrRaw(OneShotPaymentLinkDtoKind::class, self::required($data, 'kind')),
            origin: self::enumOrRaw(OneShotPaymentLinkDtoOrigin::class, self::required($data, 'origin')),
            url: self::required($data, 'url'),
            slug: self::required($data, 'slug'),
            status: self::enumOrRaw(OneShotPaymentLinkDtoStatus::class, self::required($data, 'status')),
            amount: self::required($data, 'amount'),
            currency: self::enumOrRaw(OneShotPaymentLinkDtoCurrency::class, self::required($data, 'currency')),
            description: self::required($data, 'description'),
            createdAt: self::required($data, 'createdAt'),
            reference: $data['reference'] ?? null,
            expiresAt: $data['expiresAt'] ?? null,
            paidAt: $data['paidAt'] ?? null,
            paymentId: $data['paymentId'] ?? null,
        ))->withRaw($data);
    }
}
