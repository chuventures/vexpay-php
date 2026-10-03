<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CreatePayoutBatchDto extends Model
{
    public function __construct(
        /**
         * Batch-level idempotency key. Same externalRef + identical items → 200 replay; conflict → 409.
         */
        public readonly string $externalRef,
        /**
         * One or more payout legs. Each item has its own externalRef (also idempotent). Failed items do not roll back successful siblings.
         *
         * @var list<BatchPayoutItemDto>
         */
        public readonly array $items,
        /**
         * Optional funding payment for marketplace settlement. Applied to every item. Sum of item montos must fit remaining net for that payment.
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
            externalRef: self::required($data, 'externalRef'),
            items: self::listOf(BatchPayoutItemDto::class, self::required($data, 'items')),
            paymentId: $data['paymentId'] ?? null,
        ))->withRaw($data);
    }
}
