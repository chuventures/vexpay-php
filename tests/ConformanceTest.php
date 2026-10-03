<?php

declare(strict_types=1);

namespace VexPay\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use VexPay\Exception\ApiException;
use VexPay\Exception\AuthenticationException;
use VexPay\Exception\ConflictException;
use VexPay\Exception\InvalidRequestException;
use VexPay\Exception\NotFoundException;
use VexPay\Exception\RateLimitException;
use VexPay\Exception\VexPayException;
use VexPay\Tests\Support\MockApi;

/**
 * Shared conformance: error-mapping, pagination, and retry fixtures from packages/sdk-spec.
 * Pass/fail must match the Node and Python suites.
 */
final class ConformanceTest extends TestCase
{
    private const ERROR_CLASS = [
        'invalid_request' => InvalidRequestException::class,
        'authentication' => AuthenticationException::class,
        'not_found' => NotFoundException::class,
        'conflict' => ConflictException::class,
        'rate_limit' => RateLimitException::class,
        'api' => ApiException::class,
    ];

    public static function fixture(string $name, bool $assoc = true): mixed
    {
        $path = dirname(__DIR__, 2) . '/sdk-spec/fixtures/' . $name;

        return json_decode((string) file_get_contents($path), $assoc, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Fixture cases keyed by name. Bodies come from the object-preserving decode so `{}` stays `{}` on the wire.
     *
     * @return iterable<string, array{0: array<string, mixed>, 1: object}>
     */
    private static function cases(string $name): iterable
    {
        $assoc = self::fixture($name);
        $objects = self::fixture($name, false);
        foreach ($assoc['cases'] as $index => $case) {
            yield $case['name'] => [$case, $objects->cases[$index]];
        }
    }

    public static function errorCases(): iterable
    {
        return self::cases('error-mapping.json');
    }

    public static function retryCases(): iterable
    {
        return self::cases('retries.json');
    }

    public static function paginationCases(): iterable
    {
        return self::cases('pagination.json');
    }

    /**
     * @param array<string, mixed> $case
     */
    #[DataProvider('errorCases')]
    public function testErrorMapping(array $case, object $raw): void
    {
        $fixture = self::fixture('error-mapping.json');
        $api = (new MockApi())->reply($case['status'], $raw->body, [$fixture['requestIdHeader'] => $fixture['requestId']]);
        $requester = $api->requester(['max_network_retries' => $case['maxNetworkRetries'] ?? 2]);

        try {
            $requester->request('POST', '/v1/payouts', [], []);
            self::fail('expected an exception');
        } catch (VexPayException $error) {
            self::assertInstanceOf(self::ERROR_CLASS[$case['errorClass']], $error);
            self::assertSame($case['status'], $error->getStatus());
            self::assertSame($case['code'], $error->getErrorCode());
            self::assertSame($case['body'], $error->getBody());
            self::assertSame($fixture['requestId'], $error->getRequestId());
            self::assertSame($case['message'], $error->getMessage());
        }
        self::assertSame(1, $api->count());
        self::assertSame([], $api->sleeps);
    }

    /**
     * @param array<string, mixed> $case
     */
    #[DataProvider('retryCases')]
    public function testRetries(array $case, object $raw): void
    {
        $fixture = self::fixture('retries.json');
        $api = new MockApi();
        foreach ($raw->responses as $response) {
            $api->reply($response->status, $response->body ?? null, (array) ($response->headers ?? []));
        }
        $requester = $api->requester([
            'max_network_retries' => $case['maxNetworkRetries'] ?? $fixture['defaultMaxNetworkRetries'],
        ]);
        $options = isset($case['idempotencyKey']) ? ['idempotency_key' => $case['idempotencyKey']] : [];
        $body = property_exists($raw, 'body') ? $case['body'] : null;
        $expect = $case['expect'];

        if (array_key_exists('ok', $expect)) {
            $result = $requester->request($case['method'], $case['path'], [], $body, $options);
            self::assertSame($expect['ok'], $result);
        } else {
            try {
                $requester->request($case['method'], $case['path'], [], $body, $options);
                self::fail('expected an exception');
            } catch (VexPayException $error) {
                self::assertInstanceOf(self::ERROR_CLASS[$expect['errorClass']], $error);
                if (isset($expect['code'])) {
                    self::assertSame($expect['code'], $error->getErrorCode());
                }
            }
        }

        self::assertSame($expect['requestCount'], $api->count());
        $keys = array_map(
            static fn (array $entry) => $entry['request']->getHeaderLine('Idempotency-Key') ?: null,
            $api->history,
        );
        if ($expect['sameIdempotencyKey'] ?? false) {
            self::assertCount(1, array_unique($keys));
            self::assertNotEmpty($keys[0]);
        }
        if (($expect['idempotencyKeyPresent'] ?? null) === true) {
            self::assertSame(36, strlen((string) $keys[0]));
        }
        if (($expect['idempotencyKeyPresent'] ?? null) === false) {
            self::assertNull($keys[0]);
        }
        if (isset($expect['idempotencyKey'])) {
            self::assertSame($expect['idempotencyKey'], $keys[0]);
        }
        if (array_key_exists('retryAfterSeconds', $expect)) {
            self::assertSame([(float) $expect['retryAfterSeconds']], $api->sleeps);
        }
    }

    /**
     * @param array<string, mixed> $case
     */
    #[DataProvider('paginationCases')]
    public function testPagination(array $case): void
    {
        $total = $case['total'];
        $api = (new MockApi())->replyWith(static function (RequestInterface $request) use ($total): Response {
            parse_str($request->getUri()->getQuery(), $query);
            $limit = (int) ($query['limit'] ?? 25);
            $start = (int) ($query['cursor'] ?? 0);
            $end = min($start + $limit, $total);
            $items = [];
            for ($i = $start; $i < $end; ++$i) {
                $items[] = [
                    'merchantId' => "mrc_{$i}",
                    'accountId' => "acct_{$i}",
                    'externalRef' => "m-{$i}",
                    'status' => 'verified',
                    'isActive' => true,
                    'name' => "Merchant {$i}",
                    'identification' => 'V12345678',
                    'createdAt' => '2026-09-22T12:00:00.000Z',
                ];
            }

            return new Response(200, [], json_encode(['items' => $items, 'nextCursor' => $end < $total ? (string) $end : null]));
        }, 10);

        $params = ['limit' => $case['limit']];
        if ($case['startCursor']) {
            $params['cursor'] = $case['startCursor'];
        }
        $ids = [];
        foreach ($api->client(['max_network_retries' => 0])->merchants->list($params) as $merchant) {
            $ids[] = $merchant->merchantId;
        }

        $expect = $case['expect'];
        self::assertCount($expect['itemCount'], $ids);
        self::assertSame($expect['firstId'], $ids[0]);
        self::assertSame($expect['lastId'], $ids[count($ids) - 1]);
        self::assertSame($expect['paths'], $api->paths());
    }
}
