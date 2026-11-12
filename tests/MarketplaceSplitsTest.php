<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models\MarketplaceSettingsDto;
use VexPay\Generated\Models\PaymentSplitViewDto;
use VexPay\Tests\Support\MockApi;

final class MarketplaceSplitsTest extends TestCase
{
    private const SPLITS = [
        ['merchantId' => '5e0c7b1a-3333-4b7e-9a51-0f4a1e9a0003', 'amount' => '6000.00', 'applicationFeePercent' => 20, 'reference' => 'order-1042/a'],
        ['merchantId' => 'mrc_5e0c7b1a44444b7e9a510f4a1e9a0004', 'amount' => '3000.00', 'applicationFeeVes' => '600.00'],
    ];

    public function testSplitsAreSentAsGivenAndReadBackPerShare(): void
    {
        $api = (new MockApi())
            ->reply(200, ['debitId' => 'd1', 'status' => 'PENDING'])
            ->reply(200, [
                'paymentId' => 'p1', 'status' => 'COMPLETED', 'method' => 'DEBITO_INMEDIATO', 'usdAmount' => 33.33, 'vesAmount' => 10000,
                'bcvRate' => 300, 'tenantName' => 'Planazo', 'createdAt' => '2026-11-11T12:00:00.000Z',
                'splits' => [[
                    'merchantId' => '5e0c7b1a-3333-4b7e-9a51-0f4a1e9a0003', 'accountId' => 'acct_5e0c7b1a33334b7e9a510f4a1e9a0003',
                    'merchantExternalRef' => 'comercio-17', 'amountVes' => '6000.00', 'applicationFeeVes' => '1200.00',
                    'applicationFeePercent' => '20.0000', 'feeVes' => '180.00', 'netVes' => '4620.00', 'reference' => 'order-1042/a',
                ]],
            ]);
        $vexpay = $api->client();

        try {
            $vexpay->payments->debit->execute(['banco' => '0191', 'monto' => '10000.00', 'splits' => self::SPLITS]);
        } catch (\Throwable) {
            // response shape is covered elsewhere; the request body is what matters here
        }
        $body = json_decode((string) $api->request(0)->getBody(), true);
        self::assertSame(self::SPLITS, $body['splits']);

        $payment = $vexpay->payments->retrieve('p1');
        self::assertIsArray($payment->splits);
        self::assertInstanceOf(PaymentSplitViewDto::class, $payment->splits[0]);
        self::assertSame('4620.00', $payment->splits[0]->netVes);
        self::assertSame('180.00', $payment->splits[0]->feeVes);
    }

    public function testMarketplaceSettingsReadAndUpdate(): void
    {
        $settings = ['merchantAutoPayoutDefault' => true, 'merchantAutoPayoutMinUsd' => '10.00'];
        $api = (new MockApi())->reply(200, $settings)->reply(200, $settings);
        $vexpay = $api->client();

        $read = $vexpay->merchants->marketplaceSettings->retrieve();
        self::assertInstanceOf(MarketplaceSettingsDto::class, $read);
        self::assertTrue($read->merchantAutoPayoutDefault);
        self::assertSame('10.00', $read->merchantAutoPayoutMinUsd);
        self::assertSame('/v1/marketplace/settings', $api->request(0)->getUri()->getPath());

        $vexpay->merchants->marketplaceSettings->update(['merchantAutoPayoutMinUsd' => null]);
        self::assertSame('PATCH', $api->request(1)->getMethod());
        self::assertSame(['merchantAutoPayoutMinUsd' => null], json_decode((string) $api->request(1)->getBody(), true));
    }
}
