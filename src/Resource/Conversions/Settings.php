<?php

declare(strict_types=1);

namespace VexPay\Resource\Conversions;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Your conversion spreads, minimum and caps, and COP auto-convert.
 */
final class Settings extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(array $options = []): M\ConversionSettingsDto
    {
        return $this->model('ConversionSettings_get', M\ConversionSettingsDto::class, options: $options);
    }

    /**
     * Only `autoConvert.COP.percent` (0–100, whole number; 0 = off) can be changed.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(array $params, array $options = []): M\ConversionSettingsDto
    {
        return $this->model('ConversionSettings_update', M\ConversionSettingsDto::class, body: $params, options: $options);
    }
}
