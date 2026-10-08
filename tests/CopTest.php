<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models\CopPaymentDto;
use VexPay\Tests\Support\MockApi;

final class CopTest extends TestCase
{
    private const PAYMENT = [
        'id' => '5e0c7b1a-2222-4b7e-9a51-0f4a1e9a0002', 'status' => 'pending', 'method' => 'COP', 'channel' => 'daviplata',
        'amountCop' => 50000, 'metadata' => [], 'createdAt' => '2026-10-08T00:00:00.000Z', 'expiresAt' => '2026-10-08T00:05:00.000Z',
    ];

    public function testDaviplataOtpCancelRefundAndBalance(): void
    {
        $api = (new MockApi())
            ->reply(201, ['next' => ['type' => 'submit_otp']] + self::PAYMENT)
            ->reply(200, ['status' => 'completed', 'feeCop' => 1750] + self::PAYMENT)
            ->reply(200, self::PAYMENT)
            ->reply(200, ['status' => 'canceled'] + self::PAYMENT)
            ->reply(200, ['status' => 'refunded'] + self::PAYMENT)
            ->reply(200, ['availableCop' => 96500, 'pendingPayoutCop' => 0, 'asOf' => '2026-10-08T00:00:00.000Z']);
        $vexpay = $api->client();
        $buyer = ['email' => 'juan@example.com', 'phone' => '3001234567', 'documentType' => 'CC', 'documentNumber' => '1234567890'];

        $payment = $vexpay->cop->payments->create(
            ['amountCop' => 50000, 'channel' => 'daviplata', 'buyer' => $buyer],
            ['idempotency_key' => 'cop-1'],
        );
        self::assertInstanceOf(CopPaymentDto::class, $payment);
        self::assertSame('submit_otp', $payment->next?->type?->value ?? $payment->next?->type);
        self::assertSame('/v1/cop/payments', $api->request(0)->getUri()->getPath());
        self::assertSame('cop-1', $api->request(0)->getHeaderLine('Idempotency-Key'));

        $done = $vexpay->cop->payments->submitOtp($payment->id, ['otp' => '123456']);
        self::assertSame('/v1/cop/payments/' . self::PAYMENT['id'] . '/otp', $api->request(1)->getUri()->getPath());
        self::assertSame(['otp' => '123456'], json_decode((string) $api->request(1)->getBody(), true));
        self::assertEquals(1750, $done->feeCop);

        self::assertSame(self::PAYMENT['id'], $vexpay->cop->payments->retrieve($payment->id)->id);
        $vexpay->cop->payments->cancel($payment->id);
        $vexpay->cop->payments->refund($payment->id);
        self::assertSame('/v1/cop/payments/' . self::PAYMENT['id'] . '/refund', $api->request(4)->getUri()->getPath());

        self::assertEquals(96500, $vexpay->cop()->balance->retrieve()->availableCop);
        self::assertSame('/v1/cop/balance', $api->request(5)->getUri()->getPath());
    }
}
