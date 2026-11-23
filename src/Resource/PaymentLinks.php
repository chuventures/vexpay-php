<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Model;
use VexPay\Pagination\CursorPage;

/**
 * One-shot, fixed-amount links (`kind` `one_shot`, ids `plk_…`) and product links (`kind` `product`,
 * created with `products->createLink()`).
 */
final class PaymentLinks extends AbstractResource
{
    /**
     * A one-shot link for a fixed USD amount, e.g. `['amount' => '25.00', 'description' => 'Torta']`.
     * Share its `url`; it is paid once. Seller accounts only.
     *
     * @param array<string, mixed> $params `amount`, `description`, `reference`, `expiresAt`
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\OneShotPaymentLinkDto
    {
        return $this->model('PaymentLinks_create', M\OneShotPaymentLinkDto::class, body: $params, options: $options);
    }

    /**
     * One-shot and product links, newest first. Items are M\OneShotPaymentLinkDto or
     * M\PaymentLinkResponseDto (check `kind`). Iterate the page for every link.
     *
     * @param array<string, mixed> $params `kind` (`one_shot`, `product`), `status`, `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        $fetch = function (?string $cursor) use ($params, $options): Model {
            $params['cursor'] = $cursor;
            $page = self::hydrate(M\PaymentLinkListDto::class, $this->send('PaymentLinks_list', [], $params, null, $options));

            return new M\PaymentLinkListDto(
                items: array_map(static fn (mixed $item) => self::link($item), $page->items),
                nextCursor: $page->nextCursor,
            );
        };

        return new CursorPage($fetch, isset($params['cursor']) ? (string) $params['cursor'] : null);
    }

    /**
     * A one-shot or product link; check `kind`.
     *
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\OneShotPaymentLinkDto|M\PaymentLinkResponseDto
    {
        return self::link($this->send('PaymentLinks_get', ['id' => $id], [], null, $options));
    }

    /**
     * Cancel an `ACTIVE` or `EXPIRED` one-shot link (cancelling a cancelled link changes nothing).
     * A paid link or a product link fails with `payment_link_not_cancellable`; turn product links off
     * with update($id, ['status' => 'disabled']).
     *
     * @param array<string, mixed> $options
     */
    public function cancel(string $id, array $options = []): M\OneShotPaymentLinkDto
    {
        return $this->model('PaymentLinks_cancel', M\OneShotPaymentLinkDto::class, ['id' => $id], options: $options);
    }

    /**
     * Product links only: one-shot links answer 409 `payment_link_not_editable`.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\PaymentLinkResponseDto
    {
        return $this->model('PaymentLinks_update', M\PaymentLinkResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * Product links only: one-shot links answer 409 `payment_link_not_editable`.
     *
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): void
    {
        $this->none('PaymentLinks_remove', ['id' => $id], $options);
    }

    private static function link(mixed $data): M\OneShotPaymentLinkDto|M\PaymentLinkResponseDto
    {
        return is_array($data) && ($data['kind'] ?? null) === 'one_shot'
            ? self::hydrate(M\OneShotPaymentLinkDto::class, $data)
            : self::hydrate(M\PaymentLinkResponseDto::class, $data);
    }
}
