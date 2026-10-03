<?php

declare(strict_types=1);

namespace VexPay\Resource\Crypto;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Every stablecoin balance (USDT and USDC).
 */
final class Balances extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function list(array $options = []): M\CryptoBalancesDto
    {
        return $this->model('Crypto_getBalances', M\CryptoBalancesDto::class, options: $options);
    }
}
