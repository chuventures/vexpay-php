<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class WebhookDeliveryDto extends Model
{
    public function __construct(
        /**
         * Delivery id. Also the `VexPay-Event-Id` header of every attempt.
         */
        public readonly string $id,
        public readonly string $event,
        public readonly WebhookDeliveryDtoStatus|string $status,
        /**
         * Attempts sent so far (automatic and manual).
         */
        public readonly float $attempts,
        public readonly string $createdAt,
        public readonly ?string $lastAttemptAt = null,
        /**
         * When the next automatic retry is due. Null when none is scheduled.
         */
        public readonly ?string $nextAttemptAt = null,
        /**
         * HTTP status your endpoint answered on the last attempt. Null on a network error or timeout.
         */
        public readonly ?float $lastResponseStatus = null,
        /**
         * First 1000 characters of your endpoint’s last reply, or the network error.
         */
        public readonly ?string $lastResponseBody = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            event: self::required($data, 'event'),
            status: self::enumOrRaw(WebhookDeliveryDtoStatus::class, self::required($data, 'status')),
            attempts: self::required($data, 'attempts'),
            createdAt: self::required($data, 'createdAt'),
            lastAttemptAt: $data['lastAttemptAt'] ?? null,
            nextAttemptAt: $data['nextAttemptAt'] ?? null,
            lastResponseStatus: $data['lastResponseStatus'] ?? null,
            lastResponseBody: $data['lastResponseBody'] ?? null,
        ))->withRaw($data);
    }
}
