<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Internal\Requester;
use VexPay\Pagination\CursorPage;
use VexPay\Resource\Customers\PaymentMethods;

/**
 * Billing customers: who subscriptions and invoices are for.
 */
final class Customers extends AbstractResource
{
    public readonly PaymentMethods $paymentMethods;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->paymentMethods = new PaymentMethods($requester);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params = [], array $options = []): M\CustomerResponseDto
    {
        return $this->model('Customers_create', M\CustomerResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of customers, newest first; iterate the result for every customer (`CustomerResponseDto`).
     *
     * @param array<string, mixed> $params `email`, `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Customers_list', M\CustomerListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\CustomerResponseDto
    {
        return $this->model('Customers_retrieve', M\CustomerResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * `null` clears a field.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\CustomerResponseDto
    {
        return $this->model('Customers_update', M\CustomerResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * Only a customer with no live subscriptions can be deleted.
     *
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): M\DeletedObjectResponseDto
    {
        return $this->model('Customers_remove', M\DeletedObjectResponseDto::class, ['id' => $id], options: $options);
    }
}
