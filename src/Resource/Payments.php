<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Internal\Requester;
use VexPay\Resource\Payments\C2p;
use VexPay\Resource\Payments\Change;
use VexPay\Resource\Payments\Credit;
use VexPay\Resource\Payments\Debit;
use VexPay\Resource\Payments\Dispersals;
use VexPay\Resource\Payments\Operations;
use VexPay\Resource\Payments\PagoMovil;
use VexPay\Resource\Payments\Vpos;

final class Payments extends AbstractResource
{
    public readonly C2p $c2p;
    public readonly Vpos $vpos;
    public readonly PagoMovil $pagoMovil;
    public readonly Debit $debit;
    public readonly Credit $credit;
    public readonly Operations $operations;
    public readonly Dispersals $dispersals;
    public readonly Change $change;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->c2p = new C2p($requester);
        $this->vpos = new Vpos($requester);
        $this->pagoMovil = new PagoMovil($requester);
        $this->debit = new Debit($requester);
        $this->credit = new Credit($requester);
        $this->operations = new Operations($requester);
        $this->dispersals = new Dispersals($requester);
        $this->change = new Change($requester);
    }

    /**
     * Bolívar methods your account can take now (`pago_movil`, `c2p`, `vpos`), with a reason when unavailable.
     *
     * @param array<string, mixed> $options
     */
    public function methods(array $options = []): M\PaymentMethodsResponseDto
    {
        return $this->model('Payments_listPaymentMethods', M\PaymentMethodsResponseDto::class, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\PaymentReceiptDto
    {
        return $this->model('Payments_getPayment', M\PaymentReceiptDto::class, ['id' => $id], options: $options);
    }

    /**
     * Look up a payment by the `externalRef` you sent.
     *
     * @param array<string, mixed> $options
     */
    public function retrieveByRef(string $externalRef, array $options = []): M\PaymentReceiptDto
    {
        return $this->model('Payments_getPaymentByRef', M\PaymentReceiptDto::class, ['externalRef' => $externalRef], options: $options);
    }

    /**
     * Reverse a completed C2P payment.
     *
     * @param array<string, mixed> $options
     */
    public function reverse(string $id, array $options = []): M\PaymentReceiptDto
    {
        return $this->model('Payments_reversePayment', M\PaymentReceiptDto::class, ['id' => $id], options: $options);
    }
}
