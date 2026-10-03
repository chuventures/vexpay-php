<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models\MerchantListResponseDto;
use VexPay\Tests\Support\MockApi;

final class PaginationTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private static function page(int $from, int $to, ?string $next): array
    {
        $items = [];
        for ($i = $from; $i < $to; ++$i) {
            $items[] = ['merchantId' => "mrc_{$i}", 'accountId' => "acct_{$i}", 'externalRef' => "m-{$i}", 'status' => 'verified', 'isActive' => true];
        }

        return ['items' => $items, 'nextCursor' => $next];
    }

    public function testFirstPageIsFetchedEagerlyAndExposed(): void
    {
        $api = (new MockApi())->reply(200, self::page(0, 2, '2'));
        $page = $api->client()->merchants->list(['limit' => 2]);

        self::assertSame(1, $api->count());
        self::assertInstanceOf(MerchantListResponseDto::class, $page->data);
        self::assertCount(2, $page->items());
        self::assertSame('2', $page->nextCursor());
    }

    public function testStoppingEarlyFetchesNoFurtherPage(): void
    {
        $api = (new MockApi())
            ->reply(200, self::page(0, 2, '2'))
            ->reply(200, self::page(2, 4, null));

        foreach ($api->client()->merchants->list(['limit' => 2])->autoPagingIterator() as $index => $merchant) {
            if ($index === 1) {
                break;
            }
        }

        self::assertSame(1, $api->count());
    }

    public function testIteratorToArrayKeepsEveryItemAcrossPages(): void
    {
        $api = (new MockApi())
            ->reply(200, self::page(0, 2, '2'))
            ->reply(200, self::page(2, 4, null));

        $items = iterator_to_array($api->client()->merchants->list(['limit' => 2]));
        self::assertCount(4, $items);
        self::assertSame('mrc_3', $items[3]->merchantId);
    }

    public function testToArrayRespectsLimit(): void
    {
        $api = (new MockApi())
            ->reply(200, self::page(0, 2, '2'))
            ->reply(200, self::page(2, 4, null));

        $items = $api->client()->merchants->list(['limit' => 2])->toArray(3);
        self::assertCount(3, $items);
        self::assertSame(2, $api->count());
    }

    public function testRepeatedCursorStopsIteration(): void
    {
        $api = (new MockApi())
            ->reply(200, self::page(0, 1, '5'))
            ->reply(200, self::page(5, 6, '5'));

        $items = iterator_to_array($api->client()->merchants->list(['limit' => 1]));
        self::assertCount(2, $items);
        self::assertSame(2, $api->count());
    }
}
