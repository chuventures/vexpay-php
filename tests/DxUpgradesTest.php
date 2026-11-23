<?php

declare(strict_types=1);

namespace VexPay\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use VexPay\Exception\InvalidRequestException;
use VexPay\Generated\Models\OneShotPaymentLinkDto;
use VexPay\Generated\Models\PaymentLinkResponseDto;
use VexPay\Generated\Models\PaymentReceiptDto;
use VexPay\Generated\Models\RotateWebhookSecretResponseDto;
use VexPay\Generated\Models\WebhookDeliveryDto;
use VexPay\Testing\FakeHttpClient;
use VexPay\Tests\Support\MockApi;
use VexPay\VexPayClient;

/**
 * Webhook deliveries/resend/rotate, payments list/export and one-shot payment links.
 */
final class DxUpgradesTest extends TestCase
{
    private const ONE_SHOT = [
        'id' => 'plk_1', 'kind' => 'one_shot', 'origin' => 'api', 'url' => 'https://pay.vexpay.app/pay/torta-x7k2',
        'slug' => 'torta-x7k2', 'status' => 'ACTIVE', 'amount' => '25.00', 'currency' => 'USD',
        'description' => 'Torta de chocolate', 'reference' => 'order-1042', 'createdAt' => '2026-11-23T12:00:00.000Z',
        'expiresAt' => null, 'paidAt' => null, 'paymentId' => null,
    ];
    private const PRODUCT_LINK = [
        'id' => 'pl_1', 'kind' => 'product', 'productId' => 'prod_1', 'slug' => 'camiseta',
        'hostedCheckoutPath' => '/pay/camiseta', 'status' => 'active', 'allowQuantity' => false,
        'createdAt' => '2026-11-23T12:00:00.000Z',
    ];
    private const RECEIPT = [
        'paymentId' => '00000000-0000-4000-8000-000000000001', 'status' => 'COMPLETED', 'method' => 'C2P',
        'usdAmount' => 25, 'vesAmount' => 20000, 'bcvRate' => 800, 'tenantName' => 'Tienda',
        'createdAt' => '2026-11-20T12:00:00.000Z',
    ];

    /** @return array<string, mixed> */
    private static function delivery(string $id, array $extra = []): array
    {
        return $extra + [
            'id' => $id, 'event' => 'payment.completed', 'status' => 'retrying', 'attempts' => 2,
            'lastAttemptAt' => '2026-11-23T12:00:00.000Z', 'nextAttemptAt' => '2026-11-23T12:05:00.000Z',
            'lastResponseStatus' => 503, 'lastResponseBody' => 'Service Unavailable', 'createdAt' => '2026-11-23T11:59:00.000Z',
        ];
    }

    public function testWebhookDeliveriesResendAndRotate(): void
    {
        $api = (new MockApi())
            ->reply(200, ['items' => [self::delivery('d_1'), self::delivery('d_2')], 'nextCursor' => 'c2'])
            ->reply(200, ['items' => [self::delivery('d_3')], 'nextCursor' => null])
            ->reply(202, self::delivery('d_1', ['status' => 'success', 'nextAttemptAt' => null]))
            ->reply(200, ['id' => 'we_1', 'secret' => 'whsec_new', 'previousSecretExpiresAt' => '2026-11-24T12:00:00.000Z'])
            ->reply(200, ['id' => 'we_1', 'secret' => 'whsec_newer', 'previousSecretExpiresAt' => null]);
        $vexpay = $api->client();

        $ids = [];
        foreach ($vexpay->webhookEndpoints->listDeliveries('we_1', ['status' => 'retrying', 'limit' => 2]) as $delivery) {
            self::assertInstanceOf(WebhookDeliveryDto::class, $delivery);
            $ids[] = $delivery->id;
        }
        self::assertSame(['d_1', 'd_2', 'd_3'], $ids);

        $resent = $vexpay->webhookEndpoints->resendDelivery('we_1', 'd_1', ['idempotency_key' => 'resend-1']);
        self::assertSame('d_1', $resent->id);
        self::assertSame('resend-1', $api->request(2)->getHeaderLine('Idempotency-Key'));

        $rotated = $vexpay->webhookEndpoints->rotateSecret('we_1');
        self::assertInstanceOf(RotateWebhookSecretResponseDto::class, $rotated);
        self::assertSame('whsec_new', $rotated->secret);
        $vexpay->webhookEndpoints->rotateSecret('we_1', ['expiresInHours' => 0]);

        self::assertSame([
            '/v1/webhooks/we_1/deliveries?status=retrying&limit=2',
            '/v1/webhooks/we_1/deliveries?status=retrying&limit=2&cursor=c2',
            '/v1/webhooks/we_1/deliveries/d_1/resend',
            '/v1/webhooks/we_1/rotate-secret',
            '/v1/webhooks/we_1/rotate-secret',
        ], $api->paths());
        self::assertSame('POST', $api->request(2)->getMethod());
        self::assertSame('{}', (string) $api->request(3)->getBody());
        self::assertSame('{"expiresInHours":0}', (string) $api->request(4)->getBody());
    }

    public function testPaymentsListAndExport(): void
    {
        $csv = "id,createdAt,completedAt,status\n1,2026-11-20T12:00:00.000Z,,COMPLETED\n";
        $api = (new MockApi())
            ->reply(200, ['items' => [self::RECEIPT], 'nextCursor' => 'c2'])
            ->reply(200, ['items' => [self::RECEIPT], 'nextCursor' => null])
            ->replyWith(static fn () => new Response(200, ['Content-Type' => 'text/csv'], $csv));
        $vexpay = $api->client();

        $all = $vexpay->payments->list(['status' => 'COMPLETED', 'createdFrom' => '2026-11-20', 'limit' => 1])->toArray();
        self::assertCount(2, $all);
        self::assertInstanceOf(PaymentReceiptDto::class, $all[0]);
        self::assertSame($csv, $vexpay->payments->export(['status' => 'COMPLETED']));
        self::assertSame([
            '/v1/payments?status=COMPLETED&createdFrom=2026-11-20&limit=1',
            '/v1/payments?status=COMPLETED&createdFrom=2026-11-20&limit=1&cursor=c2',
            '/v1/payments/export?status=COMPLETED',
        ], $api->paths());
    }

    public function testExportRefusalCarriesCodeAndDocUrl(): void
    {
        $api = (new MockApi())->reply(400, [
            'statusCode' => 400, 'error' => 'export_range_too_long', 'message' => 'At most 366 days',
            'code' => 'export_range_too_long', 'docUrl' => 'https://docs.vexpay.app/errors#export_range_too_long',
        ]);

        try {
            $api->client()->payments->export(['createdFrom' => '2024-01-01']);
            self::fail('expected an exception');
        } catch (InvalidRequestException $error) {
            self::assertSame('export_range_too_long', $error->getErrorCode());
            self::assertSame('https://docs.vexpay.app/errors#export_range_too_long', $error->getDocUrl());
        }
    }

    public function testOneShotPaymentLinks(): void
    {
        $api = (new MockApi())
            ->reply(201, self::ONE_SHOT)
            ->reply(200, ['items' => [self::ONE_SHOT, self::PRODUCT_LINK], 'nextCursor' => null])
            ->reply(200, self::ONE_SHOT)
            ->reply(200, self::PRODUCT_LINK)
            ->reply(200, ['status' => 'CANCELLED'] + self::ONE_SHOT);
        $vexpay = $api->client();

        $link = $vexpay->paymentLinks->create(
            ['amount' => '25.00', 'description' => 'Torta de chocolate', 'reference' => 'order-1042'],
            ['idempotency_key' => 'link-1'],
        );
        self::assertSame(self::ONE_SHOT['url'], $link->url);
        self::assertSame('link-1', $api->request(0)->getHeaderLine('Idempotency-Key'));

        $items = $vexpay->paymentLinks->list(['kind' => 'one_shot', 'limit' => 10])->items();
        self::assertInstanceOf(OneShotPaymentLinkDto::class, $items[0]);
        self::assertInstanceOf(PaymentLinkResponseDto::class, $items[1]);

        self::assertInstanceOf(OneShotPaymentLinkDto::class, $vexpay->paymentLinks->retrieve('plk_1'));
        self::assertInstanceOf(PaymentLinkResponseDto::class, $vexpay->paymentLinks->retrieve('pl_1'));
        self::assertSame('CANCELLED', $vexpay->paymentLinks->cancel('plk_1')->status->value);

        self::assertSame([
            '/v1/payment-links',
            '/v1/payment-links?kind=one_shot&limit=10',
            '/v1/payment-links/plk_1',
            '/v1/payment-links/pl_1',
            '/v1/payment-links/plk_1/cancel',
        ], $api->paths());
        self::assertSame('POST', $api->request(4)->getMethod());
    }

    public function testFakeAnswersEitherLinkKindAndCsv(): void
    {
        $vexpay = new VexPayClient(['api_key' => 'test', 'http_client' => new FakeHttpClient()]);

        self::assertInstanceOf(OneShotPaymentLinkDto::class, $vexpay->paymentLinks->retrieve('plk_9'));
        self::assertInstanceOf(PaymentLinkResponseDto::class, $vexpay->paymentLinks->retrieve('pl_9'));
        self::assertStringStartsWith('id,createdAt,', $vexpay->payments->export());
    }
}
