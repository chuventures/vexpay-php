<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

final class PaymentLinks extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\PaymentLinkResponseDto
    {
        return $this->model('PaymentLinks_get', M\PaymentLinkResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\PaymentLinkResponseDto
    {
        return $this->model('PaymentLinks_update', M\PaymentLinkResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): void
    {
        $this->none('PaymentLinks_remove', ['id' => $id], $options);
    }
}
