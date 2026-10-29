<?php

declare(strict_types=1);

namespace VexPay\Resource\Cop;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Colombian peso payments: PSE and Bancolombia (bank redirect), Bancolombia QR, Bre-B (QR / transfer
 * key), Nequi (push approval) or Daviplata (SMS code or redirect). Cards are taken only on the hosted checkout.
 * Payments complete asynchronously — listen for `payment.completed` / `payment.failed`.
 */
final class Payments extends AbstractResource
{
    /**
     * Create a payment in whole pesos; `buyer` is required for every channel except `breb`, with
     * `termsAccepted => true` when `cop->channels()` says `needsTermsAcceptance`; `pse` also needs
     * `pse.bankCode`. `next->type` says what the buyer does: `show_qr`, `approve_in_app`, `submit_otp`,
     * `redirect` (send them to `next->url`) or `redirect_pending` (retrieve again shortly).
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
     * Daviplata with `next->type === 'submit_otp'`: submit the SMS code. A wrong code fails with `invalid_otp`.
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
     * Full refund of a completed payment (card within 24 h, Bre-B within 96 h). Channels that cannot be
     * refunded through the API fail with `refund_not_supported`.
     *
     * @param array<string, mixed> $options
     */
    public function refund(string $id, array $options = []): M\CopPaymentDto
    {
        return $this->model('CopPayments_refund', M\CopPaymentDto::class, ['id' => $id], options: $options);
    }
}
