<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Account payout dispersion (advanced payments, enabled per account).
 */
final class Dispersals extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\AccountPayoutDispersionResponseDto
    {
        return $this->model('R4Operations_dispersarPagos', M\AccountPayoutDispersionResponseDto::class, body: $params, options: $options);
    }
}
