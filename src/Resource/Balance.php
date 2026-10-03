<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

final class Balance extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(array $options = []): M\PlatformBalanceDto
    {
        return $this->model('Balance_getBalance', M\PlatformBalanceDto::class, options: $options);
    }
}
