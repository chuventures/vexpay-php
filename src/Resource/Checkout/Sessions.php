<?php

declare(strict_types=1);

namespace VexPay\Resource\Checkout;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Single-purchase checkouts: redirect to `url`, or embed with @vexpay/js using `clientSecret`.
 */
final class Sessions extends AbstractResource
{
    /**
     * `clientSecret` is returned only here — hand it to the browser, never store or log it.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\CheckoutSessionResponseDto
    {
        return $this->model('CheckoutSessions_create', M\CheckoutSessionResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\CheckoutSessionResponseDto
    {
        return $this->model('CheckoutSessions_retrieve', M\CheckoutSessionResponseDto::class, ['id' => $id], options: $options);
    }
}
