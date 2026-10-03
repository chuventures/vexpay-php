<?php

declare(strict_types=1);

namespace VexPay\Tests;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ConnectTimeoutException;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use VexPay\Exception\ApiConnectionException;
use VexPay\Exception\ApiTimeoutException;
use VexPay\Exception\ConfigurationException;
use VexPay\Exception\VexPayException;
use VexPay\Generated\Models\BankResponseDto;
use VexPay\Tests\Support\MockApi;
use VexPay\Version;
use VexPay\VexPayClient;

final class ClientTest extends TestCase
{
    public function testRefusesToConstructWithoutApiKey(): void
    {
        $this->expectException(ConfigurationException::class);
        new VexPayClient('');
    }

    public function testRefusesWhitespaceApiKeyInOptions(): void
    {
        $this->expectException(ConfigurationException::class);
        new VexPayClient(['api_key' => '   ']);
    }

    public function testRejectsUnknownOptions(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('apiKey');
        new VexPayClient(['api_key' => 'sk_test', 'apiKey' => 'typo']);
    }

    public function testRejectsInvalidHttpClient(): void
    {
        $this->expectException(ConfigurationException::class);
        new VexPayClient(['api_key' => 'sk_test', 'http_client' => new \stdClass()]);
    }

    public function testConstructsWithDefaultTransport(): void
    {
        $client = new VexPayClient('sk_live_x');
        self::assertInstanceOf(VexPayClient::class, $client);
        self::assertSame($client->payments, $client->payments());
    }

    public function testSendsAuthAndUserAgentHeadersToBaseUrl(): void
    {
        $api = (new MockApi())->reply(200, [['code' => '0169', 'name' => 'R4', 'services' => []]]);
        $api->client(['api_key' => ' sk_test_abc '])->banks->list();

        $request = $api->request();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('https://api.test/v1/banks', (string) $request->getUri());
        self::assertSame('sk_test_abc', $request->getHeaderLine('x-api-key'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame('vexpay-php/' . Version::VERSION . ' php/' . PHP_VERSION, $request->getHeaderLine('User-Agent'));
        self::assertSame('', $request->getHeaderLine('Idempotency-Key'));
    }

    public function testPassesTimeoutToGuzzlePerAttempt(): void
    {
        $api = (new MockApi())->reply(200, [])->reply(200, []);
        $client = $api->client(['timeout' => 12]);
        $client->banks->list();
        $client->banks->list(['timeout' => 3]);

        self::assertSame(12.0, $api->history[0]['options']['timeout']);
        self::assertSame(3.0, $api->history[1]['options']['timeout']);
    }

    public function testCustomPsr18ClientReceivesEveryRequest(): void
    {
        $psr18 = new class () implements ClientInterface {
            /** @var list<RequestInterface> */
            public array $requests = [];

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $this->requests[] = $request;

                return new Response(201, [], '{"id":"cs_1","object":"checkout.session","status":"open","url":"https://pay.test/cs_1","amountUsd":"25.00","metadata":{},"allowedOrigins":[],"methods":["c2p"],"expiresAt":"2026-10-03T00:00:00Z","createdAt":"2026-10-02T00:00:00Z","livemode":false}');
            }
        };
        $factory = new HttpFactory();
        $client = new VexPayClient([
            'api_key' => 'sk_test',
            'base_url' => 'https://custom.test/',
            'http_client' => $psr18,
            'request_factory' => $factory,
            'stream_factory' => $factory,
        ]);

        $session = $client->checkout->sessions->create(['amountUsd' => 25]);

        self::assertSame('cs_1', $session->id);
        self::assertCount(1, $psr18->requests);
        $request = $psr18->requests[0];
        self::assertSame('https://custom.test/v1/checkout/sessions', (string) $request->getUri());
        self::assertSame('sk_test', $request->getHeaderLine('x-api-key'));
        self::assertStringStartsWith('vexpay-php/', $request->getHeaderLine('User-Agent'));
        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
        self::assertSame('{"amountUsd":25}', (string) $request->getBody());
        self::assertMatchesRegularExpression('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $request->getHeaderLine('Idempotency-Key'));
    }

    public function testConnectionErrorsAreRetriedThenSurfaced(): void
    {
        $api = new MockApi();
        for ($i = 0; $i < 3; ++$i) {
            $api->failWith(new ConnectException('Connection refused', new Request('GET', '/v1/banks')));
        }

        try {
            $api->requester()->request('GET', '/v1/banks');
            self::fail('expected an exception');
        } catch (ApiConnectionException $error) {
            self::assertNotInstanceOf(ApiTimeoutException::class, $error);
            self::assertInstanceOf(VexPayException::class, $error);
        }
        self::assertSame(3, $api->count());
        self::assertCount(2, $api->sleeps);
    }

    public function testTimeoutsMapToTimeoutException(): void
    {
        $request = new Request('GET', '/v1/banks');
        $api = (new MockApi())->failWith(class_exists(ConnectTimeoutException::class)
            ? new ConnectTimeoutException('Connection timed out', $request)
            : new ConnectException('cURL error 28', $request, null, ['errno' => 28]));

        $this->expectException(ApiTimeoutException::class);
        $api->requester(['max_network_retries' => 0])->request('GET', '/v1/banks');
    }

    public function testQueryEncodingDropsNullsAndStringifiesBooleans(): void
    {
        $api = (new MockApi())->reply(200, ['usdAmount' => 10, 'bcvRate' => 36.5, 'vesAmount' => 365, 'source' => 'bcv', 'fetchedAt' => 'x']);
        try {
            $api->client()->quotes->retrieve(['usdAmount' => 10, 'skip' => null, 'flag' => true]);
        } catch (VexPayException) {
            // shape is irrelevant here; only the URL is asserted
        }
        self::assertSame('/v1/quote?usdAmount=10&flag=true', $api->paths()[0]);
    }

    public function testPathParametersAreEncoded(): void
    {
        $api = (new MockApi())->reply(404, ['error' => 'not_found']);
        try {
            $api->client(['max_network_retries' => 0])->payments->retrieveByRef('order/1 2');
        } catch (VexPayException) {
        }
        self::assertSame('/v1/payments/by-ref/order%2F1%202', $api->paths()[0]);
    }

    public function testBanksListHydratesModels(): void
    {
        $api = (new MockApi())->reply(200, [['code' => '0169', 'name' => 'R4', 'services' => ['c2p']]]);
        $banks = $api->client()->banks->list();
        self::assertContainsOnlyInstancesOf(BankResponseDto::class, $banks);
        self::assertSame('0169', $banks[0]->code);
    }
}
