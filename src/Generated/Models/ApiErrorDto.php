<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ApiErrorDto extends Model
{
    public function __construct(
        /**
         * Stable machine-readable code, on every error. Branch on this field. Lowercase snake_case, except risk-decline and bank codes that already were uppercase (e.g. `CARD_VELOCITY_BLOCKED`, `BANK_REJECTED`), which keep their value. Each code is described at `docUrl`.
         */
        public readonly string $code,
        /**
         * The error catalog entry for `code`: what it means and what to do.
         */
        public readonly string $docUrl,
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
         * Machine-readable error code (e.g. `external_ref_conflict`, `insufficient_balance`, `idempotency_key_reused`, `live_mode_not_activated`, `rate_limited`) or, for Nest default errors, a short label such as `Bad Request`. Domain errors may include extra route-specific fields.
         */
        public readonly ?string $error = null,
        /**
         * Only on a 429 `rate_limited`: whole seconds to wait before retrying (same value as the `Retry-After` header).
         */
        public readonly ?float $retryAfterSeconds = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            code: self::required($data, 'code'),
            docUrl: self::required($data, 'docUrl'),
            statusCode: $data['statusCode'] ?? null,
            message: $data['message'] ?? null,
            error: $data['error'] ?? null,
            retryAfterSeconds: $data['retryAfterSeconds'] ?? null,
        ))->withRaw($data);
    }
}
