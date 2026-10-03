<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * VES payouts to verified merchants. `externalRef` is the idempotency key.
 */
final class Payouts extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\PayoutResponseDto
    {
        return $this->model('Payouts_create', M\PayoutResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function createInstant(array $params, array $options = []): M\PayoutResponseDto
    {
        return $this->model('Payouts_createInstant', M\PayoutResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function createBatch(array $params, array $options = []): M\PayoutBatchResponseDto
    {
        return $this->model('Payouts_createBatch', M\PayoutBatchResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of payouts; iterate the result for every payout (`PayoutResponseDto`).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Payouts_list', M\PayoutListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\PayoutResponseDto
    {
        return $this->model('Payouts_getById', M\PayoutResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieveByRef(string $externalRef, array $options = []): M\PayoutResponseDto
    {
        return $this->model('Payouts_getByRef', M\PayoutResponseDto::class, ['externalRef' => $externalRef], options: $options);
    }
}
