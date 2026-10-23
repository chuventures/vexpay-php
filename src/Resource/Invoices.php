<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * Invoices opened by subscriptions each billing period.
 */
final class Invoices extends AbstractResource
{
    /**
     * First page of invoices, newest first; iterate the result for every invoice (`InvoiceResponseDto`).
     *
     * @param array<string, mixed> $params `customer`, `subscription`, `status`, `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Invoices_list', M\InvoiceListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\InvoiceResponseDto
    {
        return $this->model('Invoices_retrieve', M\InvoiceResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Void an open invoice.
     *
     * @param array<string, mixed> $options
     */
    public function void(string $id, array $options = []): M\InvoiceResponseDto
    {
        return $this->model('Invoices_void', M\InvoiceResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Mark an open invoice uncollectible; it stays payable.
     *
     * @param array<string, mixed> $options
     */
    public function markUncollectible(string $id, array $options = []): M\InvoiceResponseDto
    {
        return $this->model('Invoices_markUncollectible', M\InvoiceResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Mark an open invoice paid outside VEXPay (cash, transfer): `['paidOutOfBand' => true]`.
     * No payment is taken and no balance changes.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function pay(string $id, array $params = ['paidOutOfBand' => true], array $options = []): M\InvoiceResponseDto
    {
        return $this->model('Invoices_pay', M\InvoiceResponseDto::class, ['id' => $id], body: $params, options: $options);
    }
}
