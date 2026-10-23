<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * Recurring USD prices on a product, used by subscriptions.
 */
final class Prices extends AbstractResource
{
    /**
     * @param array<string, mixed> $params `product`, `unitAmountUsd`, `recurring` (`interval`, `intervalCount`)
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\PriceResponseDto
    {
        return $this->model('Prices_create', M\PriceResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of prices; iterate the result for every price (`PriceResponseDto`).
     *
     * @param array<string, mixed> $params `product`, `active`, `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Prices_list', M\PriceListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\PriceResponseDto
    {
        return $this->model('Prices_retrieve', M\PriceResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Only `active`, `nickname` and `metadata` can change; the amount and interval are fixed.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\PriceResponseDto
    {
        return $this->model('Prices_update', M\PriceResponseDto::class, ['id' => $id], body: $params, options: $options);
    }
}
