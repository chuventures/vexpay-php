<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Débito inmediato (advanced payments, enabled per account).
 */
final class Debit extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function requestOtp(array $params, array $options = []): M\DebitOtpResponseDto
    {
        return $this->model('R4Operations_generarOtp', M\DebitOtpResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function execute(array $params, array $options = []): M\ImmediateDebitResponseDto
    {
        return $this->model('R4Operations_debitoInmediato', M\ImmediateDebitResponseDto::class, body: $params, options: $options);
    }
}
