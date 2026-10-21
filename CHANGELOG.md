# Changelog

## 0.10.0

- Checkout sessions can split the payment with one of your merchants: `'merchantId' => …` (UUID or `mrc_` id) and optional `'applicationFeePercent' => 3` on `checkout->sessions->create()`, echoed on create and retrieve. Sessions with a merchant offer bolívar methods only (`c2p`, `pago_movil`, `vpos`); when the payment completes your commission stays with you and the seller's net goes to the merchant's balance. Sessions may also be refused with `invalid_data` for a method you turned off in Portal → Payment methods.

## 0.9.0

- Balances are held 24h before payouts can spend them (tenant balance hold). Balance reads add `heldVes`/`held`/`heldCop` and `nextReleaseAt`; `GET /v1/balance` adds `balanceHoldHours`; balance movements carry `availableAt` while held. Payout `insufficient_balance` errors include the held amount and `nextReleaseAt`. Onward payouts add the `waiting_release` status with `sendAfter` (converted, waiting for the hold to end before sending). All new fields are optional.

## 0.8.0

- Pay in bolívars, receive USDT: Pago Móvil verify and C2P request/execute accept `'onwardPayout' => ['network' => …, 'address' => …, 'tag' => …]`. Once the payment completes, its net VES is converted to USDT and sent to that wallet. Payment reads and `payment.*` webhooks carry `onwardPayout` (status `pending` | `converting` | `sending` | `completed` | `held` | `failed` | `canceled`, with `conversionId`, `payoutId`, `amountUsdt`, `feeUsdt`, `txHash`, `reason`). New webhook event `onward_payout.updated` (`Webhook::EVENTS`).
- Quotes and payment receipts add `rate` and `rateSource` (`BCV` | `MARKET`): the Bolívar rate the amount was priced at, per your account's rate setting.
- VPOS payments accept an optional `beneficiary` (who the funds are for when it is not a merchant; shown to ops only).

## 0.7.0

- Add `$vexpay->payments->methods()` — the bolívar methods your account can take now (`pago_movil`, `c2p`, `vpos`), with a `reason` when unavailable.
- C2P accepts `vesAmount` on `$vexpay->payments->c2p->request()` and `execute()`: it locks the exact bolívars debited (USD derived at BCV); `usdAmount` is now optional. Executing an intent charges the bolívar amount stored on the intent; amounts sent on execute must match it.
- Checkout sessions accept `"methods": ["pago_movil"]` (Pago Móvil the buyer sends from their bank app).

## 0.6.0

- Conversions accept Colombian pesos: `conversions->quotes->create(['sourceCurrency' => 'COP', 'sourceAmount' => '1000000'])` (or `targetAmountUsdt`) converts COP to USDT at the market rate plus your COP spread. Quotes and conversions add `sourceCurrency`, `sourceAmount`, `origin` (`api` | `auto`) and `paymentId`; `sourceAmountVes` is `null` on COP conversions. `conversions->list()` filters by `sourceCurrency`.
- Add `conversions->settings->retrieve()` / `update()` — read your spreads, minimum and caps, and turn on auto-convert (`autoConvert.COP.percent`).
- New webhook event `conversion.created`.

## 0.5.0

- Add `cop` — Colombian pesos through Bre-B, Nequi and Daviplata: `cop->payments->create()`, `retrieve()`, `submitOtp()`, `cancel()`, `refund()` and `cop->balance->retrieve()`. COP must be enabled on your account.

## 0.4.0

- Checkout sessions accept `'methods' => ['cop']`: Colombian pesos through Bre-B, Nequi and Daviplata on the hosted checkout, priced from `amountUsd` at VEX Pay's USDT/COP rate. `cop` is offered by default when COP is enabled on your account. COP payment reads and `payment.*` webhooks for checkout payments add `amountUsd` and `copRate`.

## 0.3.0

- Add `balance->transactions->list()`: every movement in your VES balance (payments, fees, payouts, reversals, card chargebacks, adjustments, seller transfers, conversions), newest first; iterate the page for every movement. The amounts sum to `ledgerNetVes` from `balance->retrieve()`, so your ledger can reconcile automatically.
- New webhook events `payment.chargeback` and `payment.chargeback_closed` for bank chargebacks on card payments, with `ledgerEntryIds` matching `balance->transactions`. `payment.reversed` adds `reversalType` (`reversal` | `chargeback`); the balance adds `chargebackFeesVes`.

## 0.2.0

- Add `conversions` to turn available VES into your USDT balance: `conversions->quotes->create()` locks a rate for 60 seconds (`sourceAmountVes` or `targetAmountUsdt`), `conversions->create(['quoteId' => …])` debits the VES and returns a `PENDING` conversion, plus `conversions->retrieve()`, `conversions->list()` (auto-paginating) and `conversions->cancel()`. New webhook events `conversion.completed` and `conversion.canceled`; the VES balance adds `convertedVes`. Conversions are enabled per account (403 `conversions_not_enabled` otherwise).

## 0.1.1

- Support Guzzle 8 (`guzzlehttp/guzzle` `^7.5 || ^8.0`), which new Laravel 13 apps ship with; 0.1.0 could not be installed alongside it. Timeouts still surface as `ApiTimeoutException` on both Guzzle versions.

## 0.1.0

- First release: `VexPayClient` with every public API operation, typed readonly models and enums, automatic `Idempotency-Key` and retries, auto-pagination, typed exceptions, and webhook verification (`Webhook::constructEvent`), and an in-memory test transport (`VexPay\Testing\FakeHttpClient`).
