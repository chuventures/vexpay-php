<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Crédito inmediato and disbursements (advanced payments, enabled per account).
 */
final class Credit extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\R4OperationResponseDto
    {
        return $this->model('R4Operations_creditoInmediato', M\R4OperationResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function toAccount(array $params, array $options = []): M\R4OperationResponseDto
    {
        return $this->model('R4Operations_creditoCuentas', M\R4OperationResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function disburse(array $params, array $options = []): M\CreditDisbursementResponseDto
    {
        return $this->model('R4Operations_dispersarCredito', M\CreditDisbursementResponseDto::class, body: $params, options: $options);
    }
}
