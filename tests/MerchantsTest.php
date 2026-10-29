<?php

declare(strict_types=1);

namespace VexPay\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models\MerchantStatementDto;
use VexPay\Generated\Models\MerchantTransferResponseDto;
use VexPay\Tests\Support\MockApi;

final class MerchantsTest extends TestCase
{
    private const MERCHANT_ID = '5e0c7b1a-3333-4b7e-9a51-0f4a1e9a0003';
    private const BALANCE = [
        'merchantId' => self::MERCHANT_ID, 'accountId' => 'acct_1', 'tenantId' => '5e0c7b1a-4444-4b7e-9a51-0f4a1e9a0004',
        'pendingVes' => '21540.00', 'availableVes' => '0.00', 'paidOutVes' => '0.00', 'ledgerNetVes' => '21540.00',
    ];
    private const CSV = "date,type,amountVes,balanceVes\n2026-11-03T12:00:00.000Z,credit,21540.00,21540.00\n";

    /** @return array<string, mixed> */
    private static function movement(string $id): array
    {
        return [
            'id' => $id, 'type' => 'credit', 'amountVes' => '21540.00', 'description' => 'Credit', 'transferKey' => 'q1-nov-u1',
            'amountUsd' => '100.00', 'rate' => '215.4000', 'rateSource' => 'bcv', 'createdAt' => '2026-11-03T12:00:00.000Z',
        ];
    }

    public function testUsdTransferReturnsBalanceAndTransferSnapshot(): void
    {
        $api = (new MockApi())->reply(200, self::BALANCE + ['transfer' => [
            'transferKey' => 'q1-nov-u1', 'amountVes' => '21540.00', 'amountUsd' => '100.00', 'rate' => '215.4000',
            'rateSource' => 'bcv', 'rateAsOf' => '2026-11-03T00:00:00.000Z',
        ]]);
        $vexpay = $api->client();

        $result = $vexpay->merchants->transfer(self::MERCHANT_ID, ['amountUsd' => '100.00', 'transferKey' => 'q1-nov-u1']);
        self::assertInstanceOf(MerchantTransferResponseDto::class, $result);
        self::assertSame('21540.00', $result->transfer->amountVes);
        self::assertSame('215.4000', $result->transfer->rate);
        self::assertSame('/v1/merchants/' . self::MERCHANT_ID . '/transfers', $api->request(0)->getUri()->getPath());
        self::assertSame(['amountUsd' => '100.00', 'transferKey' => 'q1-nov-u1'], json_decode((string) $api->request(0)->getBody(), true));
    }

    public function testListTransactionsWalksEveryPage(): void
    {
        $api = (new MockApi())
            ->reply(200, ['items' => [self::movement('m1'), self::movement('m2')], 'nextCursor' => 'c2'])
            ->reply(200, ['items' => [self::movement('m3')], 'nextCursor' => null]);
        $vexpay = $api->client();

        $ids = [];
        foreach ($vexpay->merchants->listTransactions(self::MERCHANT_ID, ['limit' => 2]) as $movement) {
            $ids[] = $movement->id;
        }
        self::assertSame(['m1', 'm2', 'm3'], $ids);
        self::assertSame('/v1/merchants/' . self::MERCHANT_ID . '/transactions', $api->request(0)->getUri()->getPath());
        self::assertSame('limit=2', $api->request(0)->getUri()->getQuery());
        self::assertSame('limit=2&cursor=c2', $api->request(1)->getUri()->getQuery());
    }

    public function testStatementAsJsonAndCsv(): void
    {
        $api = (new MockApi())
            ->reply(200, [
                'merchantId' => self::MERCHANT_ID, 'month' => '2026-11', 'from' => '2026-11-01T04:00:00.000Z',
                'to' => '2026-12-01T04:00:00.000Z', 'openingVes' => '0.00', 'closingVes' => '21540.00',
                'movements' => [self::movement('m1')],
            ])
            ->replyWith(static fn () => new Response(200, ['Content-Type' => 'text/csv; charset=utf-8'], self::CSV));
        $vexpay = $api->client();

        $statement = $vexpay->merchants->retrieveStatement(self::MERCHANT_ID, ['month' => '2026-11']);
        self::assertInstanceOf(MerchantStatementDto::class, $statement);
        self::assertSame('21540.00', $statement->closingVes);
        self::assertCount(1, $statement->movements);
        self::assertSame('month=2026-11&format=json', $api->request(0)->getUri()->getQuery());

        self::assertSame(self::CSV, $vexpay->merchants->retrieveStatementCsv(self::MERCHANT_ID, ['month' => '2026-11']));
        self::assertSame('/v1/merchants/' . self::MERCHANT_ID . '/statement', $api->request(1)->getUri()->getPath());
        self::assertSame('month=2026-11&format=csv', $api->request(1)->getUri()->getQuery());
    }
}
