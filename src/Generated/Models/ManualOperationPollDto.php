<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ManualOperationPollDto extends Model
{
    public function __construct(
        /**
         * Which pending entity to reconcile.
         */
        public readonly ManualOperationPollDtoKind|string $kind,
        /**
         * Payment, payout, or verification deposit id (not the network operation id).
         */
        public readonly string $id,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            kind: self::enumOrRaw(ManualOperationPollDtoKind::class, self::required($data, 'kind')),
            id: self::required($data, 'id'),
        ))->withRaw($data);
    }
}
