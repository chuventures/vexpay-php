<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class DeleteMerchantResponseDto extends Model
{
    public function __construct(
        public readonly bool $deleted,
        public readonly string $merchantId,
        public readonly string $externalRef,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            deleted: self::required($data, 'deleted'),
            merchantId: self::required($data, 'merchantId'),
            externalRef: self::required($data, 'externalRef'),
        ))->withRaw($data);
    }
}
