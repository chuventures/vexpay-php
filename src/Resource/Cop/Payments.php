<?php

declare(strict_types=1);

namespace VexPay\Resource\Cop;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Colombian peso payments: Bre-B (QR / transfer key), Nequi (push approval) or Daviplata (SMS code).
 * Payments complete asynchronously — listen for `payment.completed` / `payment.failed`.
 */
final class Payments extends AbstractResource
{
    /**
     * Create a payment in whole pesos; `buyer` is required for `nequi` and `daviplata`. `next->type`
     * says what the buyer does: `show_qr`, `approve_in_app` or `submit_otp`.
     * Pass `['idempotency_key' => …]` in options to retry safely.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\CopPaymentDto
    {
        return $this->model('CopPayments_create', M\CopPaymentDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\CopPaymentDto
    {
        return $this->model('CopPayments_get', M\CopPaymentDto::class, ['id' => $id], options: $options);
    }

    /**
     * Daviplata: submit the code the buyer received by SMS. A wrong code fails with `invalid_otp`.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function submitOtp(string $id, array $params, array $options = []): M\CopPaymentDto
    {
        return $this->model('CopPayments_submitOtp', M\CopPaymentDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * Cancel a pending payment.
     *
     * @param array<string, mixed> $options
     */
    public function cancel(string $id, array $options = []): M\CopPaymentDto
    {
        return $this->model('CopPayments_cancel', M\CopPaymentDto::class, ['id' => $id], options: $options);
    }

    /**
     * Full refund of a completed payment, within 96 hours.
     *
     * @param array<string, mixed> $options
     */
    public function refund(string $id, array $options = []): M\CopPaymentDto
    {
        return $this->model('CopPayments_refund', M\CopPaymentDto::class, ['id' => $id], options: $options);
    }
}
