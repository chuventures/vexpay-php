<?php

declare(strict_types=1);

namespace VexPay\Resource\Cop;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Your COP balance, in whole pesos. Kept apart from VES and stablecoins.
 */
final class Balance extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(array $options = []): M\CopBalanceDto
    {
        return $this->model('CopPayments_balance', M\CopBalanceDto::class, options: $options);
    }
}
