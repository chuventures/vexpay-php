<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * No-code products sold through hosted payment links.
 */
final class Products extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\ProductResponseDto
    {
        return $this->model('Products_create', M\ProductResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of products; iterate the result for every product (`ProductResponseDto`).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Products_list', M\ProductListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\ProductResponseDto
    {
        return $this->model('Products_get', M\ProductResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\ProductResponseDto
    {
        return $this->model('Products_update', M\ProductResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): void
    {
        $this->none('Products_remove', ['id' => $id], $options);
    }

    /**
     * Publish a shareable `/pay/:slug` link for this product.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function createLink(string $id, array $params, array $options = []): M\PaymentLinkResponseDto
    {
        return $this->model('Products_createLink', M\PaymentLinkResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function listLinks(string $id, array $options = []): M\PaymentLinkListResponseDto
    {
        return $this->model('Products_listLinks', M\PaymentLinkListResponseDto::class, ['id' => $id], options: $options);
    }
}
