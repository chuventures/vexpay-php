<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Exception\ConflictException;
use VexPay\Generated\Models\PayoutResponseDtoStatus;
use VexPay\Generated\Routes;
use VexPay\Pagination\CursorPage;
use VexPay\Resource\AbstractResource;
use VexPay\Testing\FakeHttpClient;
use VexPay\Testing\RecordedRequest;
use VexPay\VexPayClient;

final class FakeHttpClientTest extends TestCase
{
    public function testEveryResourceMethodGetsAHydratableAnswer(): void
    {
        $http = new FakeHttpClient();
        $client = new VexPayClient(['api_key' => 'test', 'http_client' => $http]);

        foreach (self::resources($client) as $resource) {
            foreach ((new \ReflectionClass($resource))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isConstructor() || $method->isStatic() || $method->getDeclaringClass()->getName() === AbstractResource::class) {
                    continue;
                }
                $args = [];
                foreach ($method->getParameters() as $parameter) {
                    if ($parameter->isOptional()) {
                        break;
                    }
                    $args[] = $parameter->getType()?->getName() === 'array' ? [] : 'x';
                }
                $result = $method->invokeArgs($resource, $args);
                if ($result instanceof CursorPage) {
                    $result->items();
                }
            }
        }

        $called = array_unique(array_map(static fn (RecordedRequest $r) => $r->operationId, $http->recorded()));
        sort($called);
        $all = array_keys(Routes::ROUTES);
        sort($all);
        self::assertSame($all, $called);
    }

    public function testCreateEchoesRequestFieldsAndRecordsTheCall(): void
    {
        $http = new FakeHttpClient();
        $client = new VexPayClient(['api_key' => 'test', 'http_client' => $http]);

        $session = $client->checkout->sessions->create(['amountUsd' => 25, 'reference' => 'order-1', 'metadata' => ['orderId' => '1']]);

        self::assertSame('25', $session->amountUsd);
        self::assertSame('order-1', $session->reference);
        self::assertSame(['orderId' => '1'], $session->metadata);
        self::assertNotEmpty($session->clientSecret);
        $recorded = $http->recorded('CheckoutSessions_create');
        self::assertCount(1, $recorded);
        self::assertSame('order-1', $recorded[0]->body['reference']);
        self::assertNotNull($recorded[0]->header('Idempotency-Key'));
    }

    public function testStubsMergeOverTheGeneratedBody(): void
    {
        $http = new FakeHttpClient(['Payouts_create' => ['status' => 'completed']]);
        $http->stub('Payouts_getById', static fn (RecordedRequest $r) => ['payoutId' => $r->pathParams['id'], 'status' => 'failed']);
        $client = new VexPayClient(['api_key' => 'test', 'http_client' => $http]);

        $payout = $client->payouts->create(['merchantId' => 'm1', 'monto' => '10.00', 'concepto' => 'c', 'externalRef' => 'r1']);
        self::assertSame(PayoutResponseDtoStatus::Completed, $payout->status);
        self::assertSame('r1', $payout->externalRef);
        self::assertSame('po_9', $client->payouts->retrieve('po_9')->payoutId);
    }

    public function testErrorStubsSurfaceAsTypedExceptions(): void
    {
        $http = new FakeHttpClient(['Payouts_create' => FakeHttpClient::error(409, 'external_ref_conflict')]);
        $client = new VexPayClient(['api_key' => 'test', 'http_client' => $http, 'max_network_retries' => 0]);

        $this->expectException(ConflictException::class);
        $client->payouts->create(['merchantId' => 'm1', 'monto' => '10.00', 'concepto' => 'c', 'externalRef' => 'r1']);
    }

    public function testLiteralSegmentsWinOverPlaceholders(): void
    {
        $http = new FakeHttpClient();
        $client = new VexPayClient(['api_key' => 'test', 'http_client' => $http]);

        $client->payouts->createBatch(['payouts' => []]);
        self::assertSame('Payouts_createBatch', $http->recorded()[0]->operationId);
    }

    /**
     * @return iterable<AbstractResource>
     */
    private static function resources(object $node): iterable
    {
        foreach ((new \ReflectionObject($node))->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $value = $property->getValue($node);
            if ($value instanceof AbstractResource) {
                yield $value;
                yield from self::resources($value);
            }
        }
    }
}
