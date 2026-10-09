<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models\ConversionDto;
use VexPay\Tests\Support\MockApi;

final class ConversionsTest extends TestCase
{
    private const CONVERSION = [
        'id' => 'c0a8f6a2-1111-4b7e-9a51-0f4a1e9a0001', 'object' => 'conversion', 'status' => 'PENDING', 'reference' => null,
        'rate' => '998.8299', 'marketRate' => '979.2450', 'spreadPercent' => '2.0000', 'rateSource' => 'market',
        'sourceCurrency' => 'VES', 'sourceAmount' => '10000.00', 'sourceAmountVes' => '10000.00', 'targetAmountUsdt' => '10.01',
        'origin' => 'api', 'paymentId' => null, 'createdAt' => '2026-10-03T00:00:00.000Z',
        'completedAt' => null, 'canceledAt' => null, 'cancelReason' => null,
    ];

    public function testQuoteConvertListCancel(): void
    {
        $api = (new MockApi())
            ->reply(201, [
                'id' => 'q1', 'object' => 'conversion_quote', 'rate' => '998.8299', 'marketRate' => '979.2450',
                'spreadPercent' => '2.0000', 'rateSource' => 'market', 'sourceCurrency' => 'VES', 'sourceAmount' => '10000.00',
                'sourceAmountVes' => '10000.00', 'targetAmountUsdt' => '10.01', 'expiresAt' => '2026-10-03T00:01:00.000Z', 'createdAt' => '2026-10-03T00:00:00.000Z',
            ])
            ->reply(201, self::CONVERSION)
            ->reply(200, ['items' => [self::CONVERSION], 'nextCursor' => null])
            ->reply(200, ['status' => 'CANCELED', 'cancelReason' => 'canceled_by_tenant'] + self::CONVERSION);
        $vexpay = $api->client();

        $quote = $vexpay->conversions->quotes->create(['sourceAmountVes' => '10000.00']);
        self::assertSame('10.01', $quote->targetAmountUsdt);
        self::assertSame('/v1/conversions/quotes', $api->request(0)->getUri()->getPath());

        $conversion = $vexpay->conversions->create(['quoteId' => $quote->id], ['idempotency_key' => 'conv-1']);
        self::assertInstanceOf(ConversionDto::class, $conversion);
        self::assertSame('conv-1', $api->request(1)->getHeaderLine('Idempotency-Key'));
        self::assertSame(['quoteId' => 'q1'], json_decode((string) $api->request(1)->getBody(), true));

        $ids = [];
        foreach ($vexpay->conversions->list(['status' => 'PENDING']) as $c) {
            $ids[] = $c->id;
        }
        self::assertSame([self::CONVERSION['id']], $ids);
        self::assertSame('status=PENDING', $api->request(2)->getUri()->getQuery());

        $canceled = $vexpay->conversions->cancel(self::CONVERSION['id']);
        self::assertSame('/v1/conversions/' . self::CONVERSION['id'] . '/cancel', $api->request(3)->getUri()->getPath());
        self::assertSame('canceled_by_tenant', $canceled->cancelReason);
    }

    public function testCopQuoteAndSettings(): void
    {
        $settings = [
            'object' => 'conversion_settings', 'enabled' => true, 'sourceCurrencies' => ['VES' => true, 'COP' => true],
            'spreadPercent' => ['VES' => '3.0000', 'COP' => '3.0000'], 'minimumUsdt' => '10.00',
            'dailyMax' => ['VES' => null, 'COP' => null], 'autoConvert' => ['COP' => ['percent' => 50]],
        ];
        $api = (new MockApi())
            ->reply(201, [
                'id' => 'q2', 'object' => 'conversion_quote', 'rate' => '4037.6000', 'marketRate' => '3920.0000',
                'spreadPercent' => '3.0000', 'rateSource' => 'market', 'sourceCurrency' => 'COP', 'sourceAmount' => '1000000',
                'sourceAmountVes' => null, 'targetAmountUsdt' => '247.67', 'expiresAt' => '2026-10-09T00:01:00.000Z',
                'createdAt' => '2026-10-09T00:00:00.000Z',
            ])
            ->reply(200, $settings)
            ->reply(200, $settings);
        $vexpay = $api->client();

        $quote = $vexpay->conversions->quotes->create(['sourceCurrency' => 'COP', 'sourceAmount' => '1000000']);
        self::assertSame('1000000', $quote->sourceAmount);
        self::assertNull($quote->sourceAmountVes);

        $read = $vexpay->conversions->settings->retrieve();
        self::assertSame(50, $read->autoConvert->COP->percent);
        self::assertSame('/v1/conversions/settings', $api->request(1)->getUri()->getPath());

        $vexpay->conversions->settings->update(['autoConvert' => ['COP' => ['percent' => 50]]]);
        self::assertSame('PATCH', $api->request(2)->getMethod());
        self::assertSame(['autoConvert' => ['COP' => ['percent' => 50]]], json_decode((string) $api->request(2)->getBody(), true));
    }
}
