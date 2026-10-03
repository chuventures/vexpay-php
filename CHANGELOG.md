# Changelog

## 0.2.0

- Add `conversions` to turn available VES into your USDT balance: `conversions->quotes->create()` locks a rate for 60 seconds (`sourceAmountVes` or `targetAmountUsdt`), `conversions->create(['quoteId' => …])` debits the VES and returns a `PENDING` conversion, plus `conversions->retrieve()`, `conversions->list()` (auto-paginating) and `conversions->cancel()`. New webhook events `conversion.completed` and `conversion.canceled`; the VES balance adds `convertedVes`. Conversions are enabled per account (403 `conversions_not_enabled` otherwise).

## 0.1.1

- Support Guzzle 8 (`guzzlehttp/guzzle` `^7.5 || ^8.0`), which new Laravel 13 apps ship with; 0.1.0 could not be installed alongside it. Timeouts still surface as `ApiTimeoutException` on both Guzzle versions.

## 0.1.0

- First release: `VexPayClient` with every public API operation, typed readonly models and enums, automatic `Idempotency-Key` and retries, auto-pagination, typed exceptions, and webhook verification (`Webhook::constructEvent`), and an in-memory test transport (`VexPay\Testing\FakeHttpClient`).
