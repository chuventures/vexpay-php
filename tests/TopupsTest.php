<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Exception\ConflictException;
use VexPay\Exception\InvalidRequestException;
use VexPay\Generated\Models\TopupDto;
use VexPay\Generated\Models\TopupDtoStatus;
use VexPay\Tests\Support\MockApi;

final class TopupsTest extends TestCase
{
    private const TOPUP = [
        'id' => 'tp_1', 'status' => 'pending', 'amountVes' => '100000.00', 'amountUsd' => '500.00', 'bcvRate' => '200.0000',
        'feePercent' => '3.5000', 'feeFixedUsd' => '0.25', 'feeVes' => null, 'creditedVes' => null,
        'sourceNote' => 'Ingresos publicidad quincena 2', 'payerPhone' => '04121234567', 'bankReference' => null,
        'expiresAt' => '2026-10-28T00:15:00.000Z', 'completedAt' => null, 'availableAt' => null, 'heldVes' => '0.00',
        'instantFeePercent' => '1.5000', 'instantFeeVes' => '0.00', 'instantReleasedAt' => null,
        'receiver' => ['bankCode' => '0169', 'phone' => '04140000000', 'identification' => 'J-000000000'],
        'test' => true, 'createdAt' => '2026-10-28T00:00:00.000Z',
    ];

    private const CREATE = [
        'amountVes' => '100000.00', 'payerPhone' => '04121234567', 'payerCedula' => 'V12345678',
        'sourceNote' => 'Ingresos publicidad quincena 2',
    ];

    public function testCreateListRetrieveSimulateInstant(): void
    {
        $completed = [
            'status' => 'completed', 'feeVes' => '3550.00', 'creditedVes' => '96450.00', 'bankReference' => '123456',
            'completedAt' => '2026-10-28T00:05:00.000Z', 'availableAt' => '2026-10-29T00:05:00.000Z',
            'heldVes' => '96450.00', 'instantFeeVes' => '1446.75', 'receiver' => null,
        ] + self::TOPUP;
        $api = (new MockApi())
            ->reply(201, self::TOPUP)
            ->reply(200, ['data' => [self::TOPUP], 'monthlyCapUsd' => '3000.00', 'monthUsedUsd' => '500.00', 'monthRemainingUsd' => '2500.00'])
            ->reply(200, self::TOPUP)
            ->reply(200, $completed)
            ->reply(200, ['heldVes' => '0.00', 'availableAt' => null, 'instantReleasedAt' => '2026-10-28T00:06:00.000Z'] + $completed);
        $vexpay = $api->client();

        $topup = $vexpay->balance->topups->create(self::CREATE, ['idempotency_key' => 'tp-1']);
        self::assertInstanceOf(TopupDto::class, $topup);
        self::assertSame('0169', $topup->receiver?->bankCode);
        self::assertSame('POST', $api->request(0)->getMethod());
        self::assertSame('/v1/balance/topups', $api->request(0)->getUri()->getPath());
        self::assertSame('tp-1', $api->request(0)->getHeaderLine('Idempotency-Key'));
        self::assertSame(self::CREATE, json_decode((string) $api->request(0)->getBody(), true));

        $list = $vexpay->balance->topups->list(['limit' => 5]);
        self::assertSame('2500.00', $list->monthRemainingUsd);
        self::assertSame('tp_1', $list->data[0]->id);
        self::assertSame('limit=5', $api->request(1)->getUri()->getQuery());

        self::assertSame('tp_1', $vexpay->balance->topups->retrieve('tp_1')->id);
        self::assertSame('/v1/balance/topups/tp_1', $api->request(2)->getUri()->getPath());

        self::assertSame(TopupDtoStatus::Completed, $vexpay->balance->topups->simulate('tp_1')->status);
        self::assertSame('/v1/balance/topups/tp_1/simulate', $api->request(3)->getUri()->getPath());

        self::assertSame('0.00', $vexpay->balance->topups->instant('tp_1')->heldVes);
        self::assertSame('POST', $api->request(4)->getMethod());
        self::assertSame('/v1/balance/topups/tp_1/instant', $api->request(4)->getUri()->getPath());
    }

    public function testNotHeld(): void
    {
        $api = (new MockApi())->reply(409, ['error' => 'not_held', 'message' => 'Nothing held']);
        try {
            $api->client()->balance->topups->instant('tp_2', ['max_network_retries' => 0]);
            self::fail('expected ConflictException');
        } catch (ConflictException $e) {
            self::assertSame('not_held', $e->getErrorCode());
        }
    }

    public function testCapExceeded(): void
    {
        $api = (new MockApi())->reply(422, [
            'error' => 'topup_cap_exceeded', 'message' => 'Over the monthly limit',
            'capUsd' => '3000.00', 'usedUsd' => '500.00', 'remainingUsd' => '2500.00', 'remainingVes' => '500000.00',
        ]);
        try {
            $api->client()->balance->topups->create(['amountVes' => '999999999.00'] + self::CREATE);
            self::fail('expected InvalidRequestException');
        } catch (InvalidRequestException $e) {
            self::assertSame('topup_cap_exceeded', $e->getErrorCode());
            self::assertSame(422, $e->getStatus());
            self::assertSame('500000.00', $e->getBody()['remainingVes']);
        }
    }
}
