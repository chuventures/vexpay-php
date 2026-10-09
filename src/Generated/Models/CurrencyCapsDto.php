<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CurrencyCapsDto extends Model
{
    public function __construct(
        /**
         * Max VES per Caracas day; `null` = no cap.
         */
        public readonly ?string $VES = null,
        /**
         * Max COP per Bogotá day; `null` = no cap.
         */
        public readonly ?string $COP = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            VES: $data['VES'] ?? null,
            COP: $data['COP'] ?? null,
        ))->withRaw($data);
    }
}
