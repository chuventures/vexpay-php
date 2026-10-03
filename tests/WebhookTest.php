<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VexPay\Exception\SignatureVerificationException;
use VexPay\Exception\VexPayException;
use VexPay\Webhook;

final class WebhookTest extends TestCase
{
    /**
     * @return iterable<string, array{0: array<string, mixed>}>
     */
    public static function signatureVectors(): iterable
    {
        foreach (ConformanceTest::fixture('webhook-signatures.json')['cases'] as $case) {
            yield $case['name'] => [$case];
        }
    }

    /**
     * @param array<string, mixed> $case
     */
    #[DataProvider('signatureVectors')]
    public function testSignatureVectors(array $case): void
    {
        $vectors = ConformanceTest::fixture('webhook-signatures.json');
        $verify = static fn () => Webhook::constructEvent(
            $case['body'],
            $case['header'] ?? null,
            $vectors['secret'],
            $vectors['toleranceSeconds'],
            $vectors['now'],
        );

        if ($case['valid']) {
            self::assertSame(json_decode($case['body'], true)['event'], $verify()->event);
        } else {
            $this->expectException(SignatureVerificationException::class);
            $verify();
        }
    }

    public function testEventNamesMatchTheSharedFixture(): void
    {
        self::assertSame(ConformanceTest::fixture('webhook-events.json')['events'], Webhook::EVENT_NAMES);
    }

    public function testGeneratedHeaderRoundTripsAndExposesTypedPaymentData(): void
    {
        $payload = json_encode([
            'event' => 'payment.completed',
            'data' => [
                'paymentId' => 'pay_1',
                'externalRef' => 'order-1042',
                'status' => 'COMPLETED',
                'method' => 'C2P',
                'usdAmount' => 25,
                'vesAmount' => 912.5,
                'bcvRate' => 36.5,
                'livemode' => false,
                'checkoutSession' => ['id' => 'cs_1', 'reference' => 'ord_1042', 'metadata' => ['orderId' => '1042']],
                'somethingNew' => 'kept',
            ],
            'timestamp' => '2026-10-02T12:00:00.000Z',
        ], JSON_THROW_ON_ERROR);
        $header = Webhook::generateTestHeader($payload, 'whsec_1');

        $event = Webhook::constructEvent($payload, [$header], 'whsec_1');

        self::assertSame('payment.completed', $event->event);
        self::assertSame('2026-10-02T12:00:00.000Z', $event->timestamp);
        self::assertTrue($event->isPaymentEvent());
        self::assertFalse($event->livemode());
        $payment = $event->payment();
        self::assertNotNull($payment);
        self::assertSame('pay_1', $payment->paymentId);
        self::assertSame('COMPLETED', $payment->status);
        self::assertSame(25.0, $payment->usdAmount);
        self::assertSame('cs_1', $payment->checkoutSession?->id);
        self::assertSame(['orderId' => '1042'], $payment->checkoutSession?->metadata);
        self::assertSame('kept', $payment->toArray()['somethingNew']);
    }

    public function testNonPaymentEventHasNoPaymentData(): void
    {
        $payload = '{"event":"merchant.verified","data":{"merchantId":"mrc_1","livemode":true},"timestamp":"t"}';
        $event = Webhook::constructEvent($payload, Webhook::generateTestHeader($payload, 's'), 's');

        self::assertNull($event->payment());
        self::assertSame('mrc_1', $event->data['merchantId']);
    }

    public function testStaleTimestampMessageMentionsTolerance(): void
    {
        $payload = '{"event":"payment.completed","data":{},"timestamp":"t"}';
        $header = Webhook::generateTestHeader($payload, 's', time() - 600);

        try {
            Webhook::constructEvent($payload, $header, 's');
            self::fail('expected an exception');
        } catch (SignatureVerificationException $error) {
            self::assertStringContainsString('tolerance', $error->getMessage());
            self::assertInstanceOf(VexPayException::class, $error);
        }
    }

    public function testZeroToleranceDisablesTheTimestampCheck(): void
    {
        $payload = '{"event":"notification.test","data":{},"timestamp":"t"}';
        $header = Webhook::generateTestHeader($payload, 's', 1);

        self::assertSame('notification.test', Webhook::constructEvent($payload, $header, 's', 0)->event);
    }

    public function testEmptySecretIsRejected(): void
    {
        $this->expectException(SignatureVerificationException::class);
        Webhook::constructEvent('{}', 't=1,v1=a', '');
    }

    public function testNonEnvelopeJsonIsRejected(): void
    {
        $payload = '[1,2,3]';
        $this->expectException(SignatureVerificationException::class);
        Webhook::constructEvent($payload, Webhook::generateTestHeader($payload, 's'), 's');
    }
}
