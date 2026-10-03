<?php

declare(strict_types=1);

namespace VexPay\Resource\Crypto;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Static deposit addresses per customer, stablecoin (`currency`) and network.
 */
final class DepositAddresses extends AbstractResource
{
    /**
     * Get or create — the same customer and network always return the same address.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\DepositAddressDto
    {
        return $this->model('Crypto_createDepositAddress', M\DepositAddressDto::class, body: $params, options: $options);
    }
}
