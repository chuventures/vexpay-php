<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateCheckoutSessionDto extends Model
{
    public function __construct(
        /**
         * USD amount, up to 2 decimals.
         */
        public readonly float $amountUsd,
        /**
         * Buyer-facing label on the checkout.
         */
        public readonly ?string $description = null,
        /**
         * Your reference, echoed on reads and webhooks.
         */
        public readonly ?string $reference = null,
        public readonly ?float $expiresInMinutes = null,
        /**
         * Where the hosted page sends the buyer after paying. https only (http://localhost allowed for test tenants).
         */
        public readonly ?string $successUrl = null,
        /**
         * Where a buyer who backs out is sent.
         */
        public readonly ?string $cancelUrl = null,
        /**
         * Origins allowed to embed this checkout with @vexpay/js. https only; http://localhost:* allowed for test tenants. Omit to allow the hosted URL only.
         *
         * @var list<string>|null
         */
        public readonly ?array $allowedOrigins = null,
        /**
         * Payment methods offered. Defaults to every method your account can accept. `c2p` is the bank pull shown as Débito Inmediato; `pago_movil` is a Pago Móvil the buyer sends from their bank app (needs Pago Móvil enabled on your account). `cop` (Colombian pesos: Bre-B, Nequi, Daviplata) needs the COP method on your account.
         *
         * @var list<CreateCheckoutSessionDtoMethods|string>|null
         */
        public readonly ?array $methods = null,
        /**
         * Up to 20 string key/value pairs (keys ≤ 40 chars, values ≤ 500 chars).
         *
         * @var array<string, string>|null
         */
        public readonly ?array $metadata = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amountUsd: self::required($data, 'amountUsd'),
            description: $data['description'] ?? null,
            reference: $data['reference'] ?? null,
            expiresInMinutes: $data['expiresInMinutes'] ?? null,
            successUrl: $data['successUrl'] ?? null,
            cancelUrl: $data['cancelUrl'] ?? null,
            allowedOrigins: $data['allowedOrigins'] ?? null,
            methods: isset($data['methods']) ? array_map(static fn ($item) => self::enumOrRaw(CreateCheckoutSessionDtoMethods::class, $item), $data['methods']) : null,
            metadata: $data['metadata'] ?? null,
        ))->withRaw($data);
    }
}
