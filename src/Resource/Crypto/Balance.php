<?php

declare(strict_types=1);

namespace VexPay\Resource\Crypto;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * One stablecoin balance (`currency`: USDT by default, or USDC). Never converted to VES.
 */
final class Balance extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function retrieve(array $params = [], array $options = []): M\CryptoBalanceDto
    {
        return $this->model('Crypto_getBalance', M\CryptoBalanceDto::class, query: $params, options: $options);
    }
}
