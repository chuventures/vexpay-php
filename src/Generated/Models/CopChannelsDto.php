<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class CopChannelsDto extends Model
{
    public function __construct(
        /**
         * @var list<CopChannelDto>
         */
        public readonly array $channels,
        /**
         * Present when `pse` is listed: banks for `pse.bankCode`.
         *
         * @var list<CopPseBankDto>|null
         */
        public readonly ?array $pseBanks = null,
        /**
         * Present when a listed channel needs terms acceptance.
         */
        public readonly ?CopTermsDto $terms = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            channels: self::listOf(CopChannelDto::class, self::required($data, 'channels')),
            pseBanks: isset($data['pseBanks']) ? self::listOf(CopPseBankDto::class, $data['pseBanks']) : null,
            terms: isset($data['terms']) ? CopTermsDto::fromArray($data['terms']) : null,
        ))->withRaw($data);
    }
}
