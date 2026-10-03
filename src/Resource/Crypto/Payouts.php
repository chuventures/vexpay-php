<?php

declare(strict_types=1);

namespace VexPay\Resource\Crypto;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Stablecoin payouts (`currency`: USDT or USDC). `idempotencyKey` (in the body) makes retries safe.
 */
final class Payouts extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\CryptoPayoutDto
    {
        return $this->model('Crypto_createPayout', M\CryptoPayoutDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\CryptoPayoutDto
    {
        return $this->model('Crypto_getPayout', M\CryptoPayoutDto::class, ['id' => $id], options: $options);
    }
}
