<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Models as M;
use VexPay\Testing\FakeHttpClient;
use VexPay\Tests\Support\MockApi;
use VexPay\VexPayClient;

final class BillingTest extends TestCase
{
    private const PAYMENT_METHOD = [
        'id' => 'pm_1', 'object' => 'payment_method', 'type' => 'domiciliacion', 'customer' => 'cus_1', 'status' => 'active',
        'phoneLast4' => '4567', 'bankCode' => '0169', 'createdAt' => '2026-10-22T00:00:00.000Z', 'livemode' => false,
    ];

    /**
     * @return array{0: VexPayClient, 1: FakeHttpClient}
     */
    private static function fake(): array
    {
        $http = new FakeHttpClient();

        return [new VexPayClient(['api_key' => 'test', 'http_client' => $http]), $http];
    }

    public function testCustomers(): void
    {
        [$vexpay, $http] = self::fake();

        $customer = $vexpay->customers->create(['name' => 'Ana', 'email' => 'ana@example.com'], ['idempotency_key' => 'cus-ana']);
        self::assertInstanceOf(M\CustomerResponseDto::class, $customer);
        $sent = $http->recorded('Customers_create')[0];
        self::assertSame('POST', $sent->method);
        self::assertSame('ana@example.com', $sent->body['email']);
        self::assertSame('cus-ana', $sent->header('Idempotency-Key'));

        $vexpay->customers->list(['email' => 'ana@example.com', 'limit' => 5]);
        self::assertSame('ana@example.com', $http->recorded('Customers_list')[0]->query['email']);

        $vexpay->customers->retrieve('cus_1');
        $vexpay->customers->update('cus_1', ['phone' => null]);
        $update = $http->recorded('Customers_update')[0];
        self::assertSame(['POST', '/v1/customers/cus_1'], [$update->method, $update->path]);
        self::assertSame(['phone' => null], $update->body);

        self::assertInstanceOf(M\DeletedObjectResponseDto::class, $vexpay->customers()->delete('cus_1'));
        self::assertSame('DELETE', $http->recorded('Customers_remove')[0]->method);
        self::assertSame('cus_1', $http->recorded('Customers_retrieve')[0]->pathParams['id']);
    }

    public function testPricesSubscriptionsAndInvoices(): void
    {
        [$vexpay, $http] = self::fake();

        $vexpay->prices->create(['product' => 'prod_1', 'unitAmountUsd' => 9.99, 'recurring' => ['interval' => 'month']]);
        $vexpay->prices->list(['product' => 'prod_1', 'active' => 'true']);
        $vexpay->prices->retrieve('price_1');
        $vexpay->prices->update('price_1', ['active' => false]);
        self::assertSame('/v1/prices/price_1', $http->recorded('Prices_update')[0]->path);
        self::assertSame('POST', $http->recorded('Prices_update')[0]->method);

        $subscription = $vexpay->subscriptions->create(['customer' => 'cus_1', 'price' => 'price_1'], ['idempotency_key' => 'sub-1']);
        self::assertInstanceOf(M\SubscriptionResponseDto::class, $subscription);
        self::assertSame('sub-1', $http->recorded('Subscriptions_create')[0]->header('Idempotency-Key'));
        $vexpay->subscriptions->list(['customer' => 'cus_1', 'status' => 'active']);
        $vexpay->subscriptions->retrieve('sub_1');
        $vexpay->subscriptions->update('sub_1', ['cancelAtPeriodEnd' => true]);
        $vexpay->subscriptions->cancel('sub_1');
        $cancel = $http->recorded('Subscriptions_cancel')[0];
        self::assertSame(['DELETE', '/v1/subscriptions/sub_1'], [$cancel->method, $cancel->path]);

        $vexpay->invoices->list(['subscription' => 'sub_1', 'status' => 'open']);
        self::assertInstanceOf(M\InvoiceResponseDto::class, $vexpay->invoices->retrieve('in_1'));
        $vexpay->invoices->void('in_1');
        $vexpay->invoices->markUncollectible('in_1', ['idempotency_key' => 'in-1-uncollectible']);
        $vexpay->invoices->pay('in_1');
        self::assertSame('/v1/invoices/in_1/void', $http->recorded('Invoices_void')[0]->path);
        self::assertSame('/v1/invoices/in_1/mark-uncollectible', $http->recorded('Invoices_markUncollectible')[0]->path);
        self::assertSame('in-1-uncollectible', $http->recorded('Invoices_markUncollectible')[0]->header('Idempotency-Key'));
        self::assertSame(['paidOutOfBand' => true], $http->recorded('Invoices_pay')[0]->body);
    }

    public function testSetupSessionsAndPaymentMethods(): void
    {
        [$vexpay, $http] = self::fake();

        $session = $vexpay->setupSessions->create(['customer' => 'cus_1', 'successUrl' => 'https://shop.example/done']);
        self::assertInstanceOf(M\SetupSessionResponseDto::class, $session);
        self::assertSame('cus_1', $http->recorded('SetupSessions_create')[0]->body['customer']);
        $vexpay->setupSessions->retrieve('seti_1');
        self::assertSame('/v1/setup-sessions/seti_1', $http->recorded('SetupSessions_retrieve')[0]->path);

        self::assertInstanceOf(M\PaymentMethodResponseDto::class, $vexpay->paymentMethods->retrieve('pm_1'));
        $vexpay->paymentMethods->detach('pm_1');
        $detach = $http->recorded('PaymentMethods_detach')[0];
        self::assertSame(['DELETE', '/v1/payment-methods/pm_1'], [$detach->method, $detach->path]);

        // The older bolívar-methods endpoint is untouched.
        self::assertInstanceOf(M\PaymentMethodsResponseDto::class, $vexpay->payments->methods());
        self::assertSame('/v1/payment-methods', $http->recorded('Payments_listPaymentMethods')[0]->path);
    }

    public function testCustomerPaymentMethodsPaginateUnderTheCustomer(): void
    {
        $api = (new MockApi())
            ->reply(200, ['items' => [self::PAYMENT_METHOD], 'nextCursor' => 'pm_1'])
            ->reply(200, ['items' => [['id' => 'pm_2'] + self::PAYMENT_METHOD], 'nextCursor' => null]);

        $ids = [];
        foreach ($api->client()->customers->paymentMethods->list('cus_1', ['limit' => 1]) as $method) {
            self::assertInstanceOf(M\PaymentMethodResponseDto::class, $method);
            $ids[] = $method->id;
        }

        self::assertSame(['pm_1', 'pm_2'], $ids);
        self::assertSame(
            ['/v1/customers/cus_1/payment-methods?limit=1', '/v1/customers/cus_1/payment-methods?limit=1&cursor=pm_1'],
            $api->paths(),
        );
    }
}
