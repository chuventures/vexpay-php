<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopPaymentDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly CopPaymentDtoStatus|string $status,
        public readonly CopPaymentDtoMethod|string $method,
        public readonly CopPaymentDtoChannel|string $channel,
        public readonly float $amountCop,
        /**
         * @var array<string, string>
         */
        public readonly array $metadata,
        public readonly string $createdAt,
        /**
         * Present once completed.
         */
        public readonly ?float $feeCop = null,
        /**
         * Hosted checkout payments only: the USD price the peso amount was computed from.
         */
        public readonly ?string $amountUsd = null,
        /**
         * Hosted checkout payments only: COP per USD the buyer was charged at.
         */
        public readonly ?string $copRate = null,
        public readonly ?string $reference = null,
        public readonly CopPaymentDtoFailureCode|string|null $failureCode = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $completedAt = null,
        /**
         * What the buyer must do next. Returned when the payment is created.
         */
        public readonly ?CopNextActionDto $next = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            status: self::enumOrRaw(CopPaymentDtoStatus::class, self::required($data, 'status')),
            method: self::enumOrRaw(CopPaymentDtoMethod::class, self::required($data, 'method')),
            channel: self::enumOrRaw(CopPaymentDtoChannel::class, self::required($data, 'channel')),
            amountCop: self::required($data, 'amountCop'),
            metadata: self::required($data, 'metadata'),
            createdAt: self::required($data, 'createdAt'),
            feeCop: $data['feeCop'] ?? null,
            amountUsd: $data['amountUsd'] ?? null,
            copRate: $data['copRate'] ?? null,
            reference: $data['reference'] ?? null,
            failureCode: isset($data['failureCode']) ? self::enumOrRaw(CopPaymentDtoFailureCode::class, $data['failureCode']) : null,
            expiresAt: $data['expiresAt'] ?? null,
            completedAt: $data['completedAt'] ?? null,
            next: isset($data['next']) ? CopNextActionDto::fromArray($data['next']) : null,
        ))->withRaw($data);
    }
}
