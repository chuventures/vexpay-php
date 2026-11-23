<?php

declare(strict_types=1);

namespace VexPay\Webhook;

/** One Pago Móvil transfer counted toward a payment paid in several transfers. */
final class PaymentWebhookTransfer
{
    private function __construct(
        public readonly ?string $reference,
        public readonly ?float $vesAmount,
        /** ISO 8601 time the transfer arrived. */
        public readonly ?string $at,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $reference = $data['reference'] ?? null;
        $amount = $data['vesAmount'] ?? null;
        $at = $data['at'] ?? null;

        return new self(
            reference: is_scalar($reference) ? (string) $reference : null,
            vesAmount: is_numeric($amount) ? (float) $amount : null,
            at: is_scalar($at) ? (string) $at : null,
        );
    }
}
