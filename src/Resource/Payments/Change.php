<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Vuelto / change payments (advanced payments, enabled per account).
 */
final class Change extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\ChangePaymentResponseDto
    {
        return $this->model('R4Operations_ejecutarVuelto', M\ChangePaymentResponseDto::class, body: $params, options: $options);
    }
}
