<?php

declare(strict_types=1);

namespace VexPay\Resource\Crypto;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Enabled networks for one stablecoin (`currency`) with the payout fee and availability for an amount.
 */
final class Networks extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     *
     * @return list<M\CryptoNetworkDto>
     */
    public function list(array $params = [], array $options = []): array
    {
        return $this->models('Crypto_listNetworks', M\CryptoNetworkDto::class, query: $params, options: $options);
    }
}
