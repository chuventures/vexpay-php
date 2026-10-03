<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ManualOperationPollResponseDto extends Model
{
    public function __construct(
        public readonly ManualOperationPollResponseDtoKind|string $kind,
        public readonly string $id,
        /**
         * Network operation id that was polled.
         */
        public readonly string $operationId,
        public readonly string $statusBefore,
        public readonly string $status,
        public readonly ?string $failureCode = null,
        /**
         * Latest network code from ConsultarOperaciones when available.
         */
        public readonly ?string $code = null,
        public readonly ?string $message = null,
        public readonly ?string $reference = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            kind: self::enumOrRaw(ManualOperationPollResponseDtoKind::class, self::required($data, 'kind')),
            id: self::required($data, 'id'),
            operationId: self::required($data, 'operationId'),
            statusBefore: self::required($data, 'statusBefore'),
            status: self::required($data, 'status'),
            failureCode: $data['failureCode'] ?? null,
            code: $data['code'] ?? null,
            message: $data['message'] ?? null,
            reference: $data['reference'] ?? null,
        ))->withRaw($data);
    }
}
