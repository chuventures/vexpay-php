<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class AccountPayoutDispersionResponseDto extends Model
{
    public function __construct(
        /**
         * Whether the bank network accepted the dispersion request.
         */
        public readonly bool $success,
        /**
         * 9-digit wire reference actually sent to the bank (last 9 digits of the request referencia).
         */
        public readonly string $referencia,
        /**
         * Network success message when provided.
         */
        public readonly ?string $message = null,
        /**
         * Network error detail when success is false.
         */
        public readonly ?string $error = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            success: self::required($data, 'success'),
            referencia: self::required($data, 'referencia'),
            message: $data['message'] ?? null,
            error: $data['error'] ?? null,
        ))->withRaw($data);
    }
}
