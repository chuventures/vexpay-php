<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class ConversionSettingsDto extends Model
{
    public function __construct(
        public readonly string $object,
        /**
         * Conversions are enabled for your account.
         */
        public readonly bool $enabled,
        /**
         * Which currencies you can convert from right now.
         */
        public readonly CurrencyFlagsDto $sourceCurrencies,
        /**
         * Your spread per source currency, in percent.
         */
        public readonly CurrencyAmountsDto $spreadPercent,
        /**
         * Smallest USDT amount a conversion may deliver.
         */
        public readonly string $minimumUsdt,
        public readonly CurrencyCapsDto $dailyMax,
        public readonly AutoConvertDto $autoConvert,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            object: self::required($data, 'object'),
            enabled: self::required($data, 'enabled'),
            sourceCurrencies: CurrencyFlagsDto::fromArray(self::required($data, 'sourceCurrencies')),
            spreadPercent: CurrencyAmountsDto::fromArray(self::required($data, 'spreadPercent')),
            minimumUsdt: self::required($data, 'minimumUsdt'),
            dailyMax: CurrencyCapsDto::fromArray(self::required($data, 'dailyMax')),
            autoConvert: AutoConvertDto::fromArray(self::required($data, 'autoConvert')),
        ))->withRaw($data);
    }
}
