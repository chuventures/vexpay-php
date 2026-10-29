<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models\SimulatedDepositDto;
use VexPay\Tests\Support\MockApi;

final class SimulateDepositTest extends TestCase
{
    public function testSimulateDepositPostsToTheSimulateRoute(): void
    {
        $api = (new MockApi())->reply(201, [
            'paymentId' => '3fd84b2d-9ad1-4f74-a2d9-0f2f56984db5', 'status' => 'COMPLETED', 'method' => 'USDT', 'currency' => 'USDT',
            'amount' => '40.00', 'fee' => '1.50', 'amountUsdt' => '40.00', 'feeUsdt' => '1.50', 'network' => 'TRC20',
            'customerRef' => 'user_123', 'txHashes' => [], 'livemode' => false, 'simulated' => true,
            'createdAt' => '2026-10-29T00:00:00.000Z',
        ]);

        $deposit = $api->client()->crypto->simulateDeposit(['customerRef' => 'user_123', 'network' => 'TRC20', 'amount' => '40.00']);

        self::assertInstanceOf(SimulatedDepositDto::class, $deposit);
        self::assertTrue($deposit->simulated);
        self::assertFalse($deposit->livemode);
        self::assertSame('1.50', $deposit->fee);
        self::assertSame('POST', $api->request(0)->getMethod());
        self::assertSame('/v1/crypto/deposit-addresses/simulate', $api->request(0)->getUri()->getPath());
        self::assertSame(
            ['customerRef' => 'user_123', 'network' => 'TRC20', 'amount' => '40.00'],
            json_decode((string) $api->request(0)->getBody(), true),
        );
    }
}
