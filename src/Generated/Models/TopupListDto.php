<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TopupListDto extends Model
{
    public function __construct(
        /**
         * @var list<TopupDto>
         */
        public readonly array $data,
        public readonly string $monthUsedUsd,
        public readonly string $monthRemainingUsd,
        public readonly ?string $monthlyCapUsd = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            data: self::listOf(TopupDto::class, self::required($data, 'data')),
            monthUsedUsd: self::required($data, 'monthUsedUsd'),
            monthRemainingUsd: self::required($data, 'monthRemainingUsd'),
            monthlyCapUsd: $data['monthlyCapUsd'] ?? null,
        ))->withRaw($data);
    }
}
