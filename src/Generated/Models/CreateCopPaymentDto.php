<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreateCopPaymentDto extends Model
{
    public function __construct(
        /**
         * Amount in whole Colombian pesos.
         */
        public readonly float $amountCop,
        /**
         * `breb`: QR code / transfer key the buyer pays from any Colombian bank app. `nequi`: push to the buyer's Nequi app. `daviplata`: SMS code the buyer reads to you.
         */
        public readonly CreateCopPaymentDtoChannel|string $channel,
        /**
         * Shown to the buyer.
         */
        public readonly ?string $description = null,
        /**
         * Your reference, echoed in reads and webhooks.
         */
        public readonly ?string $reference = null,
        /**
         * Up to 20 string key/value pairs (keys ≤ 40 chars, values ≤ 500 chars).
         *
         * @var array<string, string>|null
         */
        public readonly ?array $metadata = null,
        /**
         * Required for `nequi` and `daviplata`; optional for `breb`.
         */
        public readonly ?CopBuyerDto $buyer = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            amountCop: self::required($data, 'amountCop'),
            channel: self::enumOrRaw(CreateCopPaymentDtoChannel::class, self::required($data, 'channel')),
            description: $data['description'] ?? null,
            reference: $data['reference'] ?? null,
            metadata: $data['metadata'] ?? null,
            buyer: isset($data['buyer']) ? CopBuyerDto::fromArray($data['buyer']) : null,
        ))->withRaw($data);
    }
}
