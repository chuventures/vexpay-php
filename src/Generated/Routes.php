<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-routes.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated;

/**
 * @internal
 */
final class Routes
{
    /** @var array<string, array{0: string, 1: string, 2: ?string}> */
    public const ROUTES = [
        'Balance_getBalance' => ['GET', '/v1/balance', 'PlatformBalanceDto'],
        'Balance_listTransactions' => ['GET', '/v1/balance/transactions', 'BalanceTransactionListDto'],
        'CheckoutSessions_create' => ['POST', '/v1/checkout/sessions', 'CheckoutSessionResponseDto'],
        'CheckoutSessions_retrieve' => ['GET', '/v1/checkout/sessions/{id}', 'CheckoutSessionResponseDto'],
        'ConversionSettings_get' => ['GET', '/v1/conversions/settings', 'ConversionSettingsDto'],
        'ConversionSettings_update' => ['PATCH', '/v1/conversions/settings', 'ConversionSettingsDto'],
        'Conversions_cancel' => ['POST', '/v1/conversions/{id}/cancel', 'ConversionDto'],
        'Conversions_create' => ['POST', '/v1/conversions', 'ConversionDto'],
        'Conversions_createQuote' => ['POST', '/v1/conversions/quotes', 'ConversionQuoteDto'],
        'Conversions_get' => ['GET', '/v1/conversions/{id}', 'ConversionDto'],
        'Conversions_list' => ['GET', '/v1/conversions', 'ConversionListDto'],
        'CopPayments_balance' => ['GET', '/v1/cop/balance', 'CopBalanceDto'],
        'CopPayments_cancel' => ['POST', '/v1/cop/payments/{id}/cancel', 'CopPaymentDto'],
        'CopPayments_create' => ['POST', '/v1/cop/payments', 'CopPaymentDto'],
        'CopPayments_get' => ['GET', '/v1/cop/payments/{id}', 'CopPaymentDto'],
        'CopPayments_refund' => ['POST', '/v1/cop/payments/{id}/refund', 'CopPaymentDto'],
        'CopPayments_submitOtp' => ['POST', '/v1/cop/payments/{id}/otp', 'CopPaymentDto'],
        'Crypto_createDepositAddress' => ['POST', '/v1/crypto/deposit-addresses', 'DepositAddressDto'],
        'Crypto_createPayout' => ['POST', '/v1/crypto/payouts', 'CryptoPayoutDto'],
        'Crypto_getBalance' => ['GET', '/v1/crypto/balance', 'CryptoBalanceDto'],
        'Crypto_getBalances' => ['GET', '/v1/crypto/balances', 'CryptoBalancesDto'],
        'Crypto_getPayout' => ['GET', '/v1/crypto/payouts/{id}', 'CryptoPayoutDto'],
        'Crypto_listNetworks' => ['GET', '/v1/crypto/networks', 'CryptoNetworkDto'],
        'Merchants_addPayoutMethod' => ['POST', '/v1/merchants/{id}/payout-methods', 'PayoutMethodResponseDto'],
        'Merchants_confirmVerify' => ['POST', '/v1/merchants/{id}/verify', 'VerifyConfirmResponseDto'],
        'Merchants_confirmVerifyMethod' => ['POST', '/v1/merchants/{id}/payout-methods/{methodId}/verify', 'VerifyConfirmResponseDto'],
        'Merchants_create' => ['POST', '/v1/merchants', 'MerchantResponseDto'],
        'Merchants_deletePayoutMethod' => ['DELETE', '/v1/merchants/{id}/payout-methods/{methodId}', null],
        'Merchants_getBalance' => ['GET', '/v1/merchants/{id}/balance', 'MerchantBalanceDto'],
        'Merchants_getById' => ['GET', '/v1/merchants/{id}', 'MerchantResponseDto'],
        'Merchants_listAuditEvents' => ['GET', '/v1/merchants/{id}/audit-events', 'MerchantAuditEventListDto'],
        'Merchants_listOrGetByRef' => ['GET', '/v1/merchants', null],
        'Merchants_listPayoutMethods' => ['GET', '/v1/merchants/{id}/payout-methods', 'PayoutMethodListResponseDto'],
        'Merchants_remove' => ['DELETE', '/v1/merchants/{id}', 'DeleteMerchantResponseDto'],
        'Merchants_setDefaultPayoutMethod' => ['POST', '/v1/merchants/{id}/payout-methods/{methodId}/default', 'PayoutMethodResponseDto'],
        'Merchants_startVerify' => ['POST', '/v1/merchants/{id}/verify/start', 'VerifyStartResponseDto'],
        'Merchants_startVerifyMethod' => ['POST', '/v1/merchants/{id}/payout-methods/{methodId}/verify/start', 'VerifyStartResponseDto'],
        'Merchants_transfer' => ['POST', '/v1/merchants/{id}/transfers', 'MerchantBalanceDto'],
        'Merchants_update' => ['PATCH', '/v1/merchants/{id}', 'MerchantResponseDto'],
        'Notifications_sendTest' => ['POST', '/v1/notifications/test', 'NotificationTestResponseDto'],
        'PaymentLinks_get' => ['GET', '/v1/payment-links/{id}', 'PaymentLinkResponseDto'],
        'PaymentLinks_remove' => ['DELETE', '/v1/payment-links/{id}', null],
        'PaymentLinks_update' => ['PATCH', '/v1/payment-links/{id}', 'PaymentLinkResponseDto'],
        'Payments_executeC2p' => ['POST', '/v1/payments/c2p', 'PaymentReceiptDto'],
        'Payments_executeVpos' => ['POST', '/v1/payments/vpos', 'PaymentReceiptDto'],
        'Payments_getBanks' => ['GET', '/v1/banks', 'BankResponseDto'],
        'Payments_getPagoMovilReceivingAccount' => ['GET', '/v1/payments/pago-movil/receiving-account', 'PagoMovilReceivingAccountDto'],
        'Payments_getPayment' => ['GET', '/v1/payments/{id}', 'PaymentReceiptDto'],
        'Payments_getPaymentByRef' => ['GET', '/v1/payments/by-ref/{externalRef}', 'PaymentReceiptDto'],
        'Payments_getQuote' => ['GET', '/v1/quote', 'QuoteResponseDto'],
        'Payments_listPaymentMethods' => ['GET', '/v1/payment-methods', 'PaymentMethodsResponseDto'],
        'Payments_requestC2p' => ['POST', '/v1/payments/c2p/request', 'C2pIntentResponseDto'],
        'Payments_reversePayment' => ['POST', '/v1/payments/{id}/reverse', 'PaymentReceiptDto'],
        'Payments_verifyPagoMovil' => ['POST', '/v1/payments/pago-movil/verify', 'PaymentReceiptDto'],
        'Payouts_create' => ['POST', '/v1/payouts', 'PayoutResponseDto'],
        'Payouts_createBatch' => ['POST', '/v1/payouts/batch', 'PayoutBatchResponseDto'],
        'Payouts_createInstant' => ['POST', '/v1/payouts/instant', 'PayoutResponseDto'],
        'Payouts_getById' => ['GET', '/v1/payouts/{id}', 'PayoutResponseDto'],
        'Payouts_getByRef' => ['GET', '/v1/payouts/by-ref/{externalRef}', 'PayoutResponseDto'],
        'Payouts_list' => ['GET', '/v1/payouts', 'PayoutListResponseDto'],
        'Products_create' => ['POST', '/v1/products', 'ProductResponseDto'],
        'Products_createLink' => ['POST', '/v1/products/{id}/links', 'PaymentLinkResponseDto'],
        'Products_get' => ['GET', '/v1/products/{id}', 'ProductResponseDto'],
        'Products_list' => ['GET', '/v1/products', 'ProductListResponseDto'],
        'Products_listLinks' => ['GET', '/v1/products/{id}/links', 'PaymentLinkListResponseDto'],
        'Products_remove' => ['DELETE', '/v1/products/{id}', null],
        'Products_update' => ['PATCH', '/v1/products/{id}', 'ProductResponseDto'],
        'R4Operations_consultarOperacion' => ['GET', '/v1/payments/operations/{id}', 'R4OperationResponseDto'],
        'R4Operations_creditoCuentas' => ['POST', '/v1/payments/credit/account', 'R4OperationResponseDto'],
        'R4Operations_creditoInmediato' => ['POST', '/v1/payments/credit', 'R4OperationResponseDto'],
        'R4Operations_debitoInmediato' => ['POST', '/v1/payments/debit', 'ImmediateDebitResponseDto'],
        'R4Operations_dispersarCredito' => ['POST', '/v1/payments/credit/disburse', 'CreditDisbursementResponseDto'],
        'R4Operations_dispersarPagos' => ['POST', '/v1/payments/payouts', 'AccountPayoutDispersionResponseDto'],
        'R4Operations_ejecutarVuelto' => ['POST', '/v1/payments/change', 'ChangePaymentResponseDto'],
        'R4Operations_generarOtp' => ['POST', '/v1/payments/debit/otp', 'DebitOtpResponseDto'],
        'R4Operations_pollOperation' => ['POST', '/v1/payments/operations/poll', 'ManualOperationPollResponseDto'],
        'TenantPayoutAccount_confirmVerify' => ['POST', '/v1/tenant/payout-account/verify', 'TenantPayoutAccountVerifyConfirmResponseDto'],
        'TenantPayoutAccount_get' => ['GET', '/v1/tenant/payout-account', 'TenantPayoutAccountResponseDto'],
        'TenantPayoutAccount_startVerify' => ['POST', '/v1/tenant/payout-account/verify/start', 'TenantPayoutAccountVerifyStartResponseDto'],
        'TenantPayoutAccount_upsert' => ['PUT', '/v1/tenant/payout-account', 'TenantPayoutAccountResponseDto'],
        'TenantPayoutAccount_upsertPost' => ['POST', '/v1/tenant/payout-account', 'TenantPayoutAccountResponseDto'],
        'Webhooks_createWebhook' => ['POST', '/v1/webhooks', 'WebhookEndpointDto'],
        'Webhooks_deleteWebhook' => ['DELETE', '/v1/webhooks/{id}', 'DeleteWebhookResponseDto'],
        'Webhooks_listWebhooks' => ['GET', '/v1/webhooks', 'WebhookEndpointDto'],
        'Webhooks_updateWebhook' => ['PATCH', '/v1/webhooks/{id}', 'WebhookEndpointDto'],
    ];

    /** Operations whose success body is a JSON array of the route's model. */
    public const LISTS = [
        'Crypto_listNetworks',
        'Payments_getBanks',
        'Webhooks_listWebhooks',
    ];
}
