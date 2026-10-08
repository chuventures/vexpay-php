# Changelog

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
