<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class BankResponseDto extends Model
{
    public function __construct(
        /**
         * Canonical four-digit SIMF bank code.
         */
        public readonly string $code,
        public readonly string $name,
        /**
         * Provider-reported services; may be empty.
         *
         * @var list<string>
         */
        public readonly array $services,
        /**
         * Public URL for a 100×100 bank logo image (PNG), or null when not uploaded. Render this next to the bank name in selectors so users can identify their bank quickly.
         */
        public readonly ?string $logoUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            code: self::required($data, 'code'),
            name: self::required($data, 'name'),
            services: self::required($data, 'services'),
            logoUrl: $data['logoUrl'] ?? null,
        ))->withRaw($data);
    }
}
