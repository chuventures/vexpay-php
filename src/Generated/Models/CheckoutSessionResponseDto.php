<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CheckoutSessionResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly CheckoutSessionResponseDtoObject|string $object,
        /**
         * `processing` while a bank charge is in flight; `failed` when the latest attempt failed (the buyer may retry until expiresAt).
         */
        public readonly CheckoutSessionResponseDtoStatus|string $status,
        public readonly string $url,
        public readonly string $amountUsd,
        /**
         * @var array<string, string>
         */
        public readonly array $metadata,
        /**
         * @var list<string>
         */
        public readonly array $allowedOrigins,
        /**
         * @var list<CheckoutSessionResponseDtoMethods|string>
         */
        public readonly array $methods,
        public readonly string $expiresAt,
        public readonly string $createdAt,
        /**
         * false for test-mode tenants.
         */
        public readonly bool $livemode,
        /**
         * Returned only by create. Pass it to @vexpay/js in the browser; never store or log it.
         */
        public readonly ?string $clientSecret = null,
        public readonly ?string $description = null,
        public readonly ?string $reference = null,
        public readonly ?string $successUrl = null,
        public readonly ?string $cancelUrl = null,
        /**
         * Latest payment for this session, once one exists.
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
            object: self::enumOrRaw(CheckoutSessionResponseDtoObject::class, self::required($data, 'object')),
            status: self::enumOrRaw(CheckoutSessionResponseDtoStatus::class, self::required($data, 'status')),
            url: self::required($data, 'url'),
            amountUsd: self::required($data, 'amountUsd'),
            metadata: self::required($data, 'metadata'),
            allowedOrigins: self::required($data, 'allowedOrigins'),
            methods: array_map(static fn ($item) => self::enumOrRaw(CheckoutSessionResponseDtoMethods::class, $item), self::required($data, 'methods')),
            expiresAt: self::required($data, 'expiresAt'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            clientSecret: $data['clientSecret'] ?? null,
            description: $data['description'] ?? null,
            reference: $data['reference'] ?? null,
            successUrl: $data['successUrl'] ?? null,
            cancelUrl: $data['cancelUrl'] ?? null,
            paymentId: $data['paymentId'] ?? null,
        ))->withRaw($data);
    }
}
