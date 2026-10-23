<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

/**
 * A customer's domiciliación payment methods (`pm_…`). List them with `customers->paymentMethods->list()`.
 * For the bolívar methods your account can take, see `payments->methods()`.
 */
final class PaymentMethods extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\PaymentMethodResponseDto
    {
        return $this->model('PaymentMethods_retrieve', M\PaymentMethodResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Detach a payment method; it is never charged again.
     *
     * @param array<string, mixed> $options
     */
    public function detach(string $id, array $options = []): M\PaymentMethodResponseDto
    {
        return $this->model('PaymentMethods_detach', M\PaymentMethodResponseDto::class, ['id' => $id], options: $options);
    }
}
