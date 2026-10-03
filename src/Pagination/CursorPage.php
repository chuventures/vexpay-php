<?php

declare(strict_types=1);

namespace VexPay\Pagination;

use VexPay\Model;

/**
 * First page of a cursor-paginated list, fetched on creation. Iterate it (or call
 * autoPagingIterator()) to walk every item across pages; later pages are fetched lazily.
 *
 *     foreach ($vexpay->merchants->list(['limit' => 100]) as $merchant) {
 *         echo $merchant->merchantId;
 *     }
 *
 * @implements \IteratorAggregate<int, mixed>
 */
final class CursorPage implements \IteratorAggregate
{
    private const DEFAULT_LIMIT = 10_000;

    /** The first page as returned by the API (has `items` and `nextCursor`). */
    public readonly Model $data;

    /**
     * @param \Closure(?string): Model $fetch
     */
    public function __construct(private readonly \Closure $fetch, private readonly ?string $startCursor = null)
    {
        $this->data = ($this->fetch)($startCursor);
    }

    /**
     * Items of the first page only.
     *
     * @return list<mixed>
     */
    public function items(): array
    {
        return self::itemsOf($this->data);
    }

    public function nextCursor(): ?string
    {
        return self::cursorOf($this->data);
    }

    /**
     * Every item across all pages, fetching each following page only when iteration reaches it.
     */
    public function autoPagingIterator(): \Generator
    {
        $page = $this->data;
        $cursor = $this->startCursor;
        while (true) {
            // Plain yield (not `yield from`) so keys keep counting across pages for iterator_to_array().
            foreach (self::itemsOf($page) as $item) {
                yield $item;
            }
            $following = self::cursorOf($page);
            // Stop on the last page, or if the API ever repeats a cursor.
            if ($following === null || $following === '' || $following === $cursor) {
                return;
            }
            $cursor = $following;
            $page = ($this->fetch)($following);
        }
    }

    public function getIterator(): \Generator
    {
        return $this->autoPagingIterator();
    }

    /**
     * @return list<mixed>
     */
    public function toArray(int $limit = self::DEFAULT_LIMIT): array
    {
        $items = [];
        foreach ($this->autoPagingIterator() as $item) {
            $items[] = $item;
            if (count($items) >= $limit) {
                break;
            }
        }

        return $items;
    }

    /**
     * @return list<mixed>
     */
    private static function itemsOf(Model $page): array
    {
        /** @var list<mixed> $items */
        $items = property_exists($page, 'items') ? $page->items : [];

        return $items;
    }

    private static function cursorOf(Model $page): ?string
    {
        return property_exists($page, 'nextCursor') ? $page->nextCursor : null;
    }
}
