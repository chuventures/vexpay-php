<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * Test mode only: frozen time for up to 3 customers, moved forward to run trials, renewals and
 * dunning in minutes. Attach a customer with `customers->create(['testClock' => $clock->id, ...])`.
 */
final class TestClocks extends AbstractResource
{
    /**
     * @param array<string, mixed> $params `frozenTime` (ISO 8601), optional `name`
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\TestClockResponseDto
    {
        return $this->model('TestClocks_create', M\TestClockResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of clocks, newest first; iterate the result for every clock (`TestClockResponseDto`).
     *
     * @param array<string, mixed> $params `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('TestClocks_list', M\TestClockListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\TestClockResponseDto
    {
        return $this->model('TestClocks_retrieve', M\TestClockResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Deletes the clock with its customers, subscriptions, invoices and payment methods.
     *
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): M\DeletedObjectResponseDto
    {
        return $this->model('TestClocks_remove', M\DeletedObjectResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Move the clock forward (at most two intervals of its shortest subscription). Returns at once
     * with `status: advancing`; poll `retrieve` or wait for the `test_clock.ready` webhook.
     *
     * @param array<string, mixed> $params `frozenTime` (ISO 8601)
     * @param array<string, mixed> $options
     */
    public function advance(string $id, array $params, array $options = []): M\TestClockResponseDto
    {
        return $this->model('TestClocks_advance', M\TestClockResponseDto::class, ['id' => $id], body: $params, options: $options);
    }
}
