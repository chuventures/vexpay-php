<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Card payments. Prefer the hosted/embedded checkout so card data never touches your servers.
 */
final class Vpos extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\PaymentReceiptDto
    {
        return $this->model('Payments_executeVpos', M\PaymentReceiptDto::class, body: $params, options: $options);
    }
}
