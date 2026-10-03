<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\TestCase;
use VexPay\Generated\Routes;
use VexPay\Tests\Support\MockApi;

final class ResourceCoverageTest extends TestCase
{
    public function testEveryOperationInTheSnapshotHasAResourceMethod(): void
    {
        $snapshot = json_decode(
            (string) file_get_contents(dirname(__DIR__, 2) . '/sdk-spec/openapi.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        $operations = [];
        foreach ($snapshot['paths'] as $item) {
            foreach (['get', 'put', 'post', 'patch', 'delete'] as $method) {
                if (isset($item[$method]['operationId'])) {
                    $operations[] = $item[$method]['operationId'];
                }
            }
        }
        sort($operations);

        $routes = array_keys(Routes::ROUTES);
        sort($routes);
        self::assertSame($operations, $routes, 'Routes.php is stale — run pnpm sdk:generate');

        $referenced = [];
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(dirname(__DIR__) . '/src/Resource'));
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            preg_match_all("/'([A-Za-z0-9]+_[A-Za-z0-9]+)'/", (string) file_get_contents($file->getPathname()), $matches);
            array_push($referenced, ...$matches[1]);
        }
        $missing = array_values(array_diff($operations, $referenced));
        self::assertSame([], $missing, 'operations without a resource method');
    }

    public function testResourceTreeMirrorsTheNodeSdk(): void
    {
        $client = (new MockApi())->client();

        self::assertTrue(method_exists($client->payments->c2p, 'request'));
        self::assertTrue(method_exists($client->payments->pagoMovil, 'receivingAccount'));
        self::assertTrue(method_exists($client->checkout->sessions, 'create'));
        self::assertTrue(method_exists($client->merchants->payoutMethods, 'confirmVerification'));
        self::assertTrue(method_exists($client->crypto->depositAddresses, 'create'));
        self::assertTrue(method_exists($client->webhookEndpoints, 'sendTest'));
        self::assertTrue(method_exists($client->tenantPayoutAccount, 'upsert'));
    }

    public function testRetrieveSendsTheMappedRoute(): void
    {
        $api = (new MockApi())->reply(200, [
            'payoutId' => 'po_1',
            'status' => 'completed',
            'merchantId' => 'mrc_1',
            'monto' => 100,
            'concepto' => 'Order 1',
            'externalRef' => 'order-1',
            'createdAt' => '2026-10-02T00:00:00Z',
        ]);

        try {
            $api->client()->payouts->retrieve('po_1');
        } catch (\Throwable) {
            // response shape is covered by ModelTest
        }
        self::assertSame('GET', $api->request()->getMethod());
        self::assertSame('/v1/payouts/po_1', $api->paths()[0]);
    }

    public function testDeleteReturnsNothing(): void
    {
        $api = (new MockApi())->reply(204);
        $api->client()->products->delete('prod_1');
        self::assertSame('DELETE', $api->request()->getMethod());
        self::assertSame('/v1/products/prod_1', $api->paths()[0]);
    }
}
