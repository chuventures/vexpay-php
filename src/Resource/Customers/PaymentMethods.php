<?php

declare(strict_types=1);

namespace VexPay\Resource\Customers;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;
use VexPay\Resource\AbstractResource;

/**
 * A customer's attached domiciliación payment methods. Retrieve or detach one with `paymentMethods`.
 */
final class PaymentMethods extends AbstractResource
{
    /**
     * First page of the customer's payment methods, newest first; iterate the result for every method (`PaymentMethodResponseDto`).
     *
     * @param array<string, mixed> $params `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(string $customerId, array $params = [], array $options = []): CursorPage
    {
        return $this->page('PaymentMethods_list', M\PaymentMethodListResponseDto::class, $params, $options, ['id' => $customerId]);
    }
}
