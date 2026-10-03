<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Confirm a Pago Móvil the customer already sent to you.
 */
final class PagoMovil extends AbstractResource
{
    /**
     * The account your customers must send the Pago Móvil to. Don't offer Pago Móvil while `configured` is false.
     *
     * @param array<string, mixed> $options
     */
    public function receivingAccount(array $options = []): M\PagoMovilReceivingAccountDto
    {
        return $this->model('Payments_getPagoMovilReceivingAccount', M\PagoMovilReceivingAccountDto::class, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function verify(array $params, array $options = []): M\PaymentReceiptDto
    {
        return $this->model('Payments_verifyPagoMovil', M\PaymentReceiptDto::class, body: $params, options: $options);
    }
}
