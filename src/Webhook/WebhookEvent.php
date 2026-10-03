<?php

declare(strict_types=1);

namespace VexPay\Webhook;

/**
 * A verified webhook delivery: `{ event, data, timestamp }`.
 */
final class WebhookEvent
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $raw
     */
    public function __construct(
        /** e.g. `payment.completed`; may be newer than this SDK's Webhook::EVENT_NAMES. */
        public readonly string $event,
        public readonly array $data,
        /** ISO-8601 time the event was created. */
        public readonly string $timestamp,
        private readonly array $raw,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        $data = $payload['data'] ?? [];

        return new self(
            event: (string) $payload['event'],
            data: is_array($data) ? $data : [],
            timestamp: (string) ($payload['timestamp'] ?? ''),
            raw: $payload,
        );
    }

    public function isPaymentEvent(): bool
    {
        return str_starts_with($this->event, 'payment.') && isset($this->data['paymentId']);
    }

    /**
     * Typed `data` for `payment.*` events; null for every other event.
     */
    public function payment(): ?PaymentWebhookData
    {
        return $this->isPaymentEvent() ? PaymentWebhookData::fromArray($this->data) : null;
    }

    public function livemode(): ?bool
    {
        return isset($this->data['livemode']) ? (bool) $this->data['livemode'] : null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
