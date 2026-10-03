<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PayoutBatchResponseDto extends Model
{
    public function __construct(
        /**
         * Batch id. Same payload + batch externalRef replays with 200.
         */
        public readonly string $batchId,
        /**
         * Per-item results in request order. Failed items include status `failed` and failureCode; they do not abort the rest of the batch.
         *
         * @var list<PayoutBatchItemResultDto>
         */
        public readonly array $items,
        /**
         * Funding payment when this batch settles a marketplace collection.
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
            batchId: self::required($data, 'batchId'),
            items: self::listOf(PayoutBatchItemResultDto::class, self::required($data, 'items')),
            paymentId: $data['paymentId'] ?? null,
        ))->withRaw($data);
    }
}
