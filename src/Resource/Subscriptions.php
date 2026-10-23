<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * Recurring billing of a customer on a price; each period opens an invoice.
 */
final class Subscriptions extends AbstractResource
{
    /**
     * @param array<string, mixed> $params `customer`, `price`, optional `collectionMethod`, `paymentMethod`, trial fields
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\SubscriptionResponseDto
    {
        return $this->model('Subscriptions_create', M\SubscriptionResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of subscriptions, newest first; iterate the result for every subscription (`SubscriptionResponseDto`).
     *
     * @param array<string, mixed> $params `customer`, `price`, `status`, `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Subscriptions_list', M\SubscriptionListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\SubscriptionResponseDto
    {
        return $this->model('Subscriptions_retrieve', M\SubscriptionResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Changes apply from the next invoice.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\SubscriptionResponseDto
    {
        return $this->model('Subscriptions_update', M\SubscriptionResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * Cancel now and void its open invoices. To stop at the end of the period instead,
     * `update($id, ['cancelAtPeriodEnd' => true])`.
     *
     * @param array<string, mixed> $options
     */
    public function cancel(string $id, array $options = []): M\SubscriptionResponseDto
    {
        return $this->model('Subscriptions_cancel', M\SubscriptionResponseDto::class, ['id' => $id], options: $options);
    }
}
