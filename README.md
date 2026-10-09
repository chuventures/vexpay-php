# VEXPay PHP SDK

The official PHP library for the [VEXPay](https://vexwallet.co/vexpay) API: accept Venezuelan payments (Pago Móvil C2P, cards, débito inmediato), pay out to merchants, create checkout sessions, and verify signed webhooks.

- Every API operation, grouped like the Node and Python SDKs (`$vexpay->checkout->sessions->create()`)
- Typed readonly models and enums generated from the VEXPay OpenAPI contract
- Safe retries: every `POST` carries an `Idempotency-Key`, so a retried charge never charges twice
- Auto-pagination
- Webhook signature verification with replay protection
- PHP 8.1+, any PSR-18 HTTP client (Guzzle 7 or 8 by default), no framework required

Using Laravel? Install [`vexpay/laravel`](https://packagist.org/packages/vexpay/laravel) instead — it wraps this SDK with config, a webhook route, events, Eloquent traits, and test fakes.

## Install

```sh
composer require vexpay/vexpay-php
```

Published on [Packagist](https://packagist.org/packages/vexpay/vexpay-php). Releases are listed in the [changelog](CHANGELOG.md).

## Quickstart

```php
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

$quote = $vexpay->quotes->retrieve(['usdAmount' => 25]);
echo "\$25 = Bs {$quote->vesAmount} at BCV {$quote->bcvRate}\n";
```

Keep your API key on the server. Use your test-mode key while you build; it runs against the sandbox provider. Request bodies and query parameters are arrays with the API's field names (`usdAmount`, `debtorBankCode`, …). Responses are typed objects from `VexPay\Generated\Models`; call `->toArray()` on any of them for the raw response, including fields newer than your SDK version.

## Collect a Pago Móvil C2P payment

C2P is two steps: create an intent (the payer's bank sends them a token by SMS), then charge with the token your customer types in.

```php
use VexPay\Generated\Models\PaymentReceiptDtoStatus;
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

$payer = [
    'usdAmount' => 25,
    'debtorId' => 'V12345678',
    'debtorCellPhone' => '584141234567',
    'debtorBankCode' => 102,
];

$intent = $vexpay->payments->c2p->request($payer + ['externalRef' => 'order-1042']);

$token = '123456'; // the customer reads it from their bank SMS and types it into your form

$payment = $vexpay->payments->c2p->execute($payer + ['intentId' => $intent->intentId, 'token' => $token]);
if ($payment->status === PaymentReceiptDtoStatus::Pending) {
    echo "{$payment->paymentId} is pending — wait for the payment.completed webhook\n";
}
```

## Checkout sessions (hosted or embedded)

Let VEXPay collect the payment details. Redirect the buyer to `url`, or embed the checkout on your own site with [`@vexpay/js`](https://www.npmjs.com/package/@vexpay/js) and the one-time `clientSecret`.

```php
use VexPay\Generated\Models\CheckoutSessionResponseDtoStatus;
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

$session = $vexpay->checkout->sessions->create([
    'amountUsd' => 25,
    'reference' => 'order-1042',
    'description' => 'Pedido #1042',
    'successUrl' => 'https://shop.example/gracias',
    'metadata' => ['orderId' => '1042'],
]);
echo $session->url, "\n"; // redirect here, or send $session->clientSecret to the browser (never log or store it)

// Later — fulfil only after checking on the server:
$current = $vexpay->checkout->sessions->retrieve($session->id);
if ($current->status === CheckoutSessionResponseDtoStatus::Paid) {
    echo "ship order 1042\n";
}
```

Enum-typed fields hold a backed enum, or the raw string when the API sends a value newer than your SDK version.

The hosted page lets the buyer pick the currency — bolívares, stablecoins or Colombian pesos — and offers every method your account accepts. Limit it with `methods` (`c2p`, `vpos`, `usdt`, `usdc`, `cop`).

## Colombian pesos (COP)

Collect pesos from buyers in Colombia through Bre-B, Nequi or Daviplata. Amounts are whole pesos, payments complete asynchronously (`payment.completed` / `payment.failed`), and completed payments go to your COP balance net of the COP fee. COP must be enabled on your account — otherwise the calls fail with `method_not_allowed` (403).

```php
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

// Bre-B: no buyer data. Show next->qrPngBase64 as an image and next->transferKey as text.
$breb = $vexpay->cop->payments->create(
    ['amountCop' => 100000, 'channel' => 'breb', 'reference' => 'order-1042'],
    ['idempotency_key' => 'order-1042-cop'],
);

$buyer = ['email' => 'juan@example.com', 'phone' => '3001234567', 'documentType' => 'CC', 'documentNumber' => '1234567890'];

// Nequi: the buyer approves a push in the Nequi app.
$vexpay->cop->payments->create(['amountCop' => 50000, 'channel' => 'nequi', 'buyer' => $buyer]);

// Daviplata: the buyer reads you the SMS code; submit it.
$davi = $vexpay->cop->payments->create(['amountCop' => 50000, 'channel' => 'daviplata', 'buyer' => $buyer]);
$vexpay->cop->payments->submitOtp($davi->id, ['otp' => '123456']);

$available = $vexpay->cop->balance->retrieve()->availableCop;
```

`cancel($id)` cancels a pending payment and `refund($id)` refunds a completed one in full within 96 hours. A webhook for a COP payment has `method` `COP`, with `channel`, `amountCop` and a lowercase `status`.

**Test mode** (test API keys use a sandbox):

| Channel | What to use | Result |
|---|---|---|
| Bre-B | No buyer data | QR and key from the sandbox. **Never send real money to them** — sandbox keys are reachable from real banks and the money is not credited. |
| Nequi | Any valid data, e.g. phone `3001234567`, `CC` `1234567890`, any email | Completes on its own within about a minute |
| Daviplata | Same buyer data (`CC`, `CE` or `TI` only) | OTP `123456`, `000000` or `111111` completes it; any other code fails with `invalid_otp` |

## Convert VES or COP to USDT

Turn available VES or Colombian pesos into your USDT balance. A quote locks the rate (market USDT rate in that currency plus your spread) for 60 seconds; accepting it debits the source at once (`conversion.created`) and returns a `PENDING` conversion. VEXPay then delivers the USDT and sends `conversion.completed` (or `conversion.canceled`, with the VES or COP returned). Conversions are on for every account that has USDT enabled (COP also needs COP enabled) — otherwise the calls fail with `conversions_not_enabled` (403). In test mode they complete immediately. COP amounts are whole pesos.

```php
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

$quote = $vexpay->conversions->quotes->create(['sourceAmountVes' => '10000.00']); // or ['targetAmountUsdt' => '50.00']

$conversion = $vexpay->conversions->create(
    ['quoteId' => $quote->id, 'reference' => 'treasury-2026-10-03'],
    ['idempotency_key' => 'convert-2026-10-03'],
);

foreach ($vexpay->conversions->list(['status' => 'PENDING']) as $c) {
    echo $c->id, ' ', $c->sourceAmount, ' ', $c->sourceCurrency, ' → ', $c->targetAmountUsdt, PHP_EOL;
}
$vexpay->conversions->cancel($conversion->id); // only while PENDING

// Colombian pesos: same flow with sourceCurrency 'COP'.
$copQuote = $vexpay->conversions->quotes->create(['sourceCurrency' => 'COP', 'sourceAmount' => '1000000']);

// Auto-convert 50% of each completed COP payment (after the fee) to USDT; 0 turns it off.
$vexpay->conversions->settings->update(['autoConvert' => ['COP' => ['percent' => 50]]]);
```

## Testing card payments

With a test API key, VPOS test cards return a fixed outcome without reaching the bank: `4242424242424242` succeeds, `4000000000009995` is declined with `G51` (insufficient funds), `4000000000000259` completes and is then charged back, and more. A decline fails exactly like a live one (422, the bank code in `code` and `failureCode`, a `payment.failed` webhook). With a live key these numbers are refused with 400 `test_card_in_live_mode`. Full list: [test cards](https://docs.pay.vexwallet.co/vpos#test-card).

## Webhooks

VEXPay signs every delivery with a `VexPay-Signature` header. Verify it with the **raw** request body — decoding and re-encoding JSON changes the bytes and breaks the signature.

```php
use VexPay\Exception\SignatureVerificationException;
use VexPay\Webhook;

function handleVexPayWebhook(string $rawBody, ?string $signature): int
{
    try {
        $event = Webhook::constructEvent($rawBody, $signature, getenv('VEXPAY_WEBHOOK_SECRET') ?: 'whsec_…');
    } catch (SignatureVerificationException) {
        return 400;
    }

    if ($event->event === 'payment.completed') {
        $payment = $event->payment();
        $reference = $payment->externalRef ?? $payment->checkoutSession?->reference;
        echo "paid {$payment->paymentId} {$reference}\n";
    }

    return 204;
}

$payload = '{"event":"payment.completed","data":{"paymentId":"pay_1","status":"COMPLETED","externalRef":"order-1042"},"timestamp":"2026-10-02T12:00:00.000Z"}';
http_response_code(handleVexPayWebhook($payload, Webhook::generateTestHeader($payload, getenv('VEXPAY_WEBHOOK_SECRET') ?: 'whsec_…')));
```

In plain PHP read the body with `file_get_contents('php://input')` and the header with `$_SERVER['HTTP_VEXPAY_SIGNATURE']`. Deliveries older than 5 minutes are rejected as possible replays; pass a different tolerance (seconds) as the fourth argument. The `VexPay-Event-Id` header identifies a delivery **attempt** — a retried delivery of the same event gets a new id — so make your handler idempotent on the payment id and status rather than on that header. In your own tests, sign fixtures with `Webhook::generateTestHeader($payload, $secret)`.

## Errors

Every exception extends `VexPay\Exception\VexPayException` and carries `getStatus()`, the API error code (`getErrorCode()`, e.g. `insufficient_balance`), the decoded `getBody()`, and `getRequestId()`.

```php
use VexPay\Exception\ConflictException;
use VexPay\Exception\InvalidRequestException;
use VexPay\Exception\NotFoundException;
use VexPay\Exception\VexPayException;
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

try {
    $vexpay->payouts->create([
        'merchantId' => '4f0c6f1e-2b7d-4c1a-9e3f-5a6b7c8d9e0f',
        'monto' => '1523.40',
        'concepto' => 'Liquidación semana 30',
        'externalRef' => 'po_2026_30_maria',
    ]);
} catch (InvalidRequestException $error) {
    echo 'fix the request: ', $error->getErrorCode(), ' ', $error->getMessage(), "\n";
} catch (NotFoundException) {
    echo "no such merchant\n";
} catch (ConflictException $error) {
    echo "externalRef reused with a different payload\n";
} catch (VexPayException $error) {
    echo $error->getStatus(), ' ', $error->getErrorCode(), ' ', $error->getMessage(), "\n";
}
```

| Exception | When |
|---|---|
| `AuthenticationException` | 401 — missing or invalid API key |
| `InvalidRequestException` | 400, 403, 410, 422 — fix the request |
| `NotFoundException` | 404 |
| `ConflictException` | 409 — e.g. `external_ref_conflict`, `idempotency_key_reused` |
| `RateLimitException` | 429, after retries |
| `ApiException` | 5xx, after retries |
| `ApiConnectionException` / `ApiTimeoutException` | no HTTP answer, after retries |
| `SignatureVerificationException` | a webhook did not verify |
| `UnexpectedResponseException` | a 2xx response did not match the expected shape |
| `ConfigurationException` | invalid client configuration (e.g. no API key) |

## Retries and idempotency

The SDK retries connection errors, timeouts, `429`, `5xx`, and `409 idempotency_request_in_progress` up to `max_network_retries` times (default 2) with exponential backoff, honouring `Retry-After`. Every `POST` gets a random `Idempotency-Key` that stays the same across its retries. Supply your own to make retries safe across process restarts too. Every method takes a last `$options` array:

```php
use VexPay\VexPayClient;

$vexpay = new VexPayClient(['api_key' => getenv('VEXPAY_API_KEY'), 'max_network_retries' => 3, 'timeout' => 20]);

$quote = $vexpay->quotes->retrieve(['usdAmount' => 10], ['timeout' => 5]);
$session = $vexpay->checkout->sessions->create(
    ['amountUsd' => 10, 'reference' => 'order-1043'],
    ['idempotency_key' => 'order-1043-session'],
);
echo $quote->vesAmount, ' ', $session->id, "\n";
```

## Pagination

`list()` on payouts, merchants, and products returns the first page; iterate it to walk every item across pages. Following pages are fetched only when iteration reaches them.

```php
use VexPay\VexPayClient;

$vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));

$page = $vexpay->merchants->list(['limit' => 100]);
echo count($page->items()), ' ', $page->nextCursor() ?? 'last page', "\n";

foreach ($vexpay->merchants->list(['status' => 'verified']) as $merchant) {
    echo $merchant->merchantId, ' ', $merchant->name, "\n";
}

$recent = $vexpay->payouts->list(['limit' => 50])->toArray(200);
echo count($recent), "\n";
```

## Configuration

```php
use VexPay\VexPayClient;

$vexpay = new VexPayClient([
    'api_key' => getenv('VEXPAY_API_KEY'),
    'base_url' => 'https://api.pay.vexwallet.co', // e.g. http://localhost:3010 for a local API
    'timeout' => 30,                              // seconds per attempt
    'max_network_retries' => 2,
]);
echo count($vexpay->banks->list()), " banks\n";
```

Pass `'http_client' => $client` with any PSR-18 client (plus `request_factory` / `stream_factory` if it does not ship PSR-17 factories) to control proxies, pooling, or instrumentation. With the default Guzzle transport the SDK enforces `timeout`; with your own client, configure timeouts on that client.

## Testing your integration

`VexPay\Testing\FakeHttpClient` is an in-memory transport: nothing leaves the process, every operation answers with a valid body (echoing the fields you sent), and every call is recorded. Stub an operation by its `operationId` to control the answer.

```php
use VexPay\Testing\FakeHttpClient;
use VexPay\VexPayClient;

$http = new FakeHttpClient([
    'Payouts_create' => ['status' => 'completed'],
    'Merchants_getById' => FakeHttpClient::error(404, 'merchant_not_found'),
]);
$vexpay = new VexPayClient(['api_key' => 'test', 'http_client' => $http]);

$payout = $vexpay->payouts->create(['merchantId' => 'mrc_1', 'monto' => '150.00', 'concepto' => 'Venta 7', 'externalRef' => 'sale-7']);

$sent = $http->recorded('Payouts_create')[0];
echo $sent->body['externalRef'], ' ', $sent->header('Idempotency-Key') !== null ? 'idempotent' : '', "\n";
```

Using Laravel? `VexPay::fake()` in `vexpay/laravel` wraps this with Laravel-style assertions.

## Resources

| Namespace | Methods |
|---|---|
| `banks` | `list` |
| `quotes` | `retrieve` |
| `balance` | `retrieve` |
| `payments` | `retrieve`, `retrieveByRef`, `reverse` |
| `payments->c2p` | `request`, `execute` |
| `payments->vpos` | `create` |
| `payments->pagoMovil` | `receivingAccount`, `verify` |
| `payments->debit` · `credit` · `operations` · `dispersals` · `change` | débito/crédito inmediato and disbursements (advanced payments) |
| `checkout->sessions` | `create`, `retrieve` |
| `crypto->balance` | `retrieve` |
| `crypto->balances` | `list` |
| `crypto->depositAddresses` | `create` |
| `crypto->networks` | `list` |
| `crypto->payouts` | `create`, `retrieve` |
| `conversions` | `create`, `list`, `retrieve`, `cancel` |
| `conversions->quotes` | `create` |
| `conversions->settings` | `retrieve`, `update` |
| `cop->payments` | `create`, `retrieve`, `submitOtp`, `cancel`, `refund` |
| `cop->balance` | `retrieve` |
| `merchants` | `create`, `list`, `retrieve`, `retrieveByRef`, `update`, `delete`, `retrieveBalance`, `transfer`, `listAuditEvents`, `startVerification`, `confirmVerification` |
| `merchants->payoutMethods` | `list`, `create`, `setDefault`, `delete`, `startVerification`, `confirmVerification` |
| `payouts` | `create`, `createInstant`, `createBatch`, `list`, `retrieve`, `retrieveByRef` |
| `products` | `create`, `list`, `retrieve`, `update`, `delete`, `createLink`, `listLinks` |
| `paymentLinks` | `retrieve`, `update`, `delete` |
| `tenantPayoutAccount` | `retrieve`, `upsert`, `create`, `startVerification`, `confirmVerification` |
| `webhookEndpoints` | `create`, `list`, `update`, `delete`, `sendTest` |
| `VexPay\Webhook` | `constructEvent`, `generateTestHeader` (offline, static) |

## License

MIT
