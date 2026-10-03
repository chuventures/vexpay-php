<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ApiErrorDto extends Model
{
    public function __construct(
        /**
         * HTTP status code mirrored in the JSON body (Nest default error shape). Absent on domain errors.
         */
        public readonly ?float $statusCode = null,
        /**
         * Human-readable error detail, or a validation error array.
         *
         * @var string|list<string>|null
         */
        public readonly string|array|null $message = null,
        /**
         * Machine-readable error code (e.g. `external_ref_conflict`, `insufficient_balance`, `idempotency_key_reused`, `live_mode_not_activated`) or, for Nest default errors, a short label such as `Bad Request`. Domain errors may include extra route-specific fields.
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
            statusCode: $data['statusCode'] ?? null,
            message: $data['message'] ?? null,
            error: $data['error'] ?? null,
        ))->withRaw($data);
    }
}
