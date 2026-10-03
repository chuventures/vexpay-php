<?php

declare(strict_types=1);

namespace VexPay\Webhook;

final class CheckoutSessionRef
{
    /**
     * @param array<string, string> $metadata
     */
    private function __construct(
        public readonly string $id,
        public readonly ?string $reference,
        public readonly array $metadata,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $reference = $data['reference'] ?? null;
        $metadata = $data['metadata'] ?? [];

        return new self(
            id: (string) $data['id'],
            reference: is_scalar($reference) ? (string) $reference : null,
            metadata: is_array($metadata) ? array_map(static fn ($value) => (string) $value, $metadata) : [],
        );
    }
}
