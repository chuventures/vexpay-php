<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Pago Móvil C2P: request the bank OTP, then charge with the customer's token.
 */
final class C2p extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function request(array $params, array $options = []): M\C2pIntentResponseDto
    {
        return $this->model('Payments_requestC2p', M\C2pIntentResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function execute(array $params, array $options = []): M\PaymentReceiptDto
    {
        return $this->model('Payments_executeC2p', M\PaymentReceiptDto::class, body: $params, options: $options);
    }
}
