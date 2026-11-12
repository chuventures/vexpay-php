<?php

declare(strict_types=1);

namespace VexPay\Resource\Merchants;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Marketplace comercio auto-payout: the default for new merchants and the payout minimum.
 */
final class MarketplaceSettings extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(array $options = []): M\MarketplaceSettingsDto
    {
        return $this->model('MarketplaceSettings_get', M\MarketplaceSettingsDto::class, options: $options);
    }

    /**
     * `merchantAutoPayoutDefault` and/or `merchantAutoPayoutMinUsd` (USD; null clears it).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(array $params, array $options = []): M\MarketplaceSettingsDto
    {
        return $this->model('MarketplaceSettings_update', M\MarketplaceSettingsDto::class, body: $params, options: $options);
    }
}
