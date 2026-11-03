<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TestClockResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        /**
         * The clock's current time.
         */
        public readonly string $frozenTime,
        /**
         * advancing while events between the old and new time are being run.
         */
        public readonly TestClockResponseDtoStatus|string $status,
        public readonly string $createdAt,
        public readonly bool $livemode,
        public readonly ?string $name = null,
        /**
         * While advancing: the time the clock is moving to.
         */
        public readonly ?string $targetTime = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            object: self::required($data, 'object'),
            frozenTime: self::required($data, 'frozenTime'),
            status: self::enumOrRaw(TestClockResponseDtoStatus::class, self::required($data, 'status')),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            name: $data['name'] ?? null,
            targetTime: $data['targetTime'] ?? null,
        ))->withRaw($data);
    }
}
