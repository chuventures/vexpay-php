<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class R4OperationResponseDto extends Model
{
    public function __construct(
        /**
         * Network status code. Common values: `202` (OTP accepted), `ACCP` (accepted/completed), `AC00` (pending — gateway auto-polls), reject codes on failure.
         */
        public readonly string $code,
        /**
         * Human-readable network message when provided.
         */
        public readonly ?string $message = null,
        /**
         * Bank reference when the operation settles synchronously.
         */
        public readonly ?string $reference = null,
        /**
         * Network operation id. Prefer this over `Id` when both are present. Use with GET /v1/payments/operations/:id.
         */
        public readonly ?string $id = null,
        /**
         * Alternate casing of the operation id some network responses use.
         */
        public readonly ?string $Id = null,
        /**
         * Present on some operation responses when the network returns an explicit success flag.
         */
        public readonly ?bool $success = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            code: self::required($data, 'code'),
            message: $data['message'] ?? null,
            reference: $data['reference'] ?? null,
            id: $data['id'] ?? null,
            Id: $data['Id'] ?? null,
            success: $data['success'] ?? null,
        ))->withRaw($data);
    }
}
