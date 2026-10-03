<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Exception\UnexpectedResponseException;
use VexPay\Exception\VexPayException;
use VexPay\Generated\Models\CheckoutSessionResponseDto;
use VexPay\Generated\Models\CheckoutSessionResponseDtoMethods;
use VexPay\Generated\Models\CheckoutSessionResponseDtoStatus;
use VexPay\Generated\Models\MerchantListResponseDto;
use VexPay\Generated\Models\MerchantResponseDto;
use VexPay\Tests\Support\MockApi;

final class ModelTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private static function session(array $overrides = []): array
    {
        return $overrides + [
            'id' => 'cs_123',
            'object' => 'checkout.session',
            'status' => 'open',
            'clientSecret' => 'cs_123_secret',
            'url' => 'https://pay.vexwallet.co/checkout/cs_123',
            'amountUsd' => '25.00',
            'description' => null,
            'metadata' => ['orderId' => '1042'],
            'allowedOrigins' => ['https://shop.test'],
            'methods' => ['c2p', 'vpos'],
            'paymentId' => null,
            'expiresAt' => '2026-10-03T00:00:00.000Z',
            'createdAt' => '2026-10-02T00:00:00.000Z',
            'livemode' => false,
        ];
    }

    public function testTypedPropertiesAndEnums(): void
    {
        $session = CheckoutSessionResponseDto::fromArray(self::session());

        self::assertSame('https://pay.vexwallet.co/checkout/cs_123', $session->url);
        self::assertSame(CheckoutSessionResponseDtoStatus::Open, $session->status);
        self::assertSame([CheckoutSessionResponseDtoMethods::C2p, CheckoutSessionResponseDtoMethods::Vpos], $session->methods);
        self::assertSame(['orderId' => '1042'], $session->metadata);
        self::assertFalse($session->livemode);
        self::assertNull($session->description);
        self::assertNull($session->successUrl);
    }

    public function testUnknownFieldsAndEnumValuesAreTolerated(): void
    {
        $session = CheckoutSessionResponseDto::fromArray(self::session([
            'status' => 'on_hold',
            'brandNewField' => ['nested' => true],
        ]));

        self::assertSame('on_hold', $session->status);
        self::assertSame(['nested' => true], $session->toArray()['brandNewField']);
        self::assertSame($session->toArray(), $session->jsonSerialize());
    }

    public function testNestedListsHydrateModels(): void
    {
        $page = MerchantListResponseDto::fromArray([
            'items' => [[
                'merchantId' => 'mrc_1',
                'accountId' => 'acct_1',
                'externalRef' => 'seller-1',
                'status' => 'verified',
                'isActive' => true,
            ]],
            'nextCursor' => null,
        ]);

        self::assertContainsOnlyInstancesOf(MerchantResponseDto::class, $page->items);
        self::assertSame('mrc_1', $page->items[0]->merchantId);
    }

    public function testMissingRequiredFieldIsAnUnexpectedResponse(): void
    {
        $api = (new MockApi())->reply(200, self::session(['url' => null]));

        try {
            $api->client()->checkout->sessions->retrieve('cs_123');
            self::fail('expected an exception');
        } catch (UnexpectedResponseException $error) {
            self::assertStringContainsString('"url"', $error->getMessage());
            self::assertInstanceOf(VexPayException::class, $error);
        }
    }

    public function testWrongFieldTypeIsAnUnexpectedResponse(): void
    {
        $api = (new MockApi())->reply(200, self::session(['livemode' => ['not' => 'a bool']]));

        $this->expectException(UnexpectedResponseException::class);
        $api->client()->checkout->sessions->retrieve('cs_123');
    }
}
