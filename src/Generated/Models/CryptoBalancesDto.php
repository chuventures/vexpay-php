<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CryptoBalancesDto extends Model
{
    public function __construct(
        /**
         * One balance per stablecoin (USDT, USDC).
         *
         * @var list<CryptoBalanceDto>
         */
        public readonly array $data,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            data: self::listOf(CryptoBalanceDto::class, self::required($data, 'data')),
        ))->withRaw($data);
    }
}
