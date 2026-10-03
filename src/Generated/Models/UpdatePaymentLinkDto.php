<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class UpdatePaymentLinkDto extends Model
{
    public function __construct(
        public readonly UpdatePaymentLinkDtoStatus|string|null $status = null,
        public readonly ?bool $allowQuantity = null,
        public readonly ?float $maxQuantity = null,
        public readonly ?string $redirectUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            status: isset($data['status']) ? self::enumOrRaw(UpdatePaymentLinkDtoStatus::class, $data['status']) : null,
            allowQuantity: $data['allowQuantity'] ?? null,
            maxQuantity: $data['maxQuantity'] ?? null,
            redirectUrl: $data['redirectUrl'] ?? null,
        ))->withRaw($data);
    }
}
