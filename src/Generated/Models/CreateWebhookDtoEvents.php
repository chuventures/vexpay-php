<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CreateWebhookDtoEvents: string
{
    case PaymentPending = 'payment.pending';
    case PaymentCompleted = 'payment.completed';
    case PaymentFailed = 'payment.failed';
    case PaymentCanceled = 'payment.canceled';
    case PaymentReversed = 'payment.reversed';
    case PaymentChargeback = 'payment.chargeback';
    case PaymentChargebackClosed = 'payment.chargeback_closed';
    case MerchantVerified = 'merchant.verified';
    case MerchantRejected = 'merchant.rejected';
    case MerchantDeactivated = 'merchant.deactivated';
    case MerchantReactivated = 'merchant.reactivated';
    case MerchantBalanceUpdated = 'merchant.balance.updated';
    case MerchantCreated = 'merchant.created';
    case MerchantActivated = 'merchant.activated';
    case MerchantUpdated = 'merchant.updated';
    case MerchantKybRequired = 'merchant.kyb_required';
    case MerchantRestricted = 'merchant.restricted';
    case MerchantCapabilityUpdated = 'merchant.capability.updated';
    case MerchantWalletCredit = 'merchant.wallet_credit';
    case PayoutCompleted = 'payout.completed';
    case PayoutFailed = 'payout.failed';
    case ConversionCreated = 'conversion.created';
    case ConversionCompleted = 'conversion.completed';
    case ConversionCanceled = 'conversion.canceled';
    case TenantStatusChanged = 'tenant.status_changed';
    case TenantApiKeyCreated = 'tenant.api_key.created';
    case TenantApiKeyRotated = 'tenant.api_key.rotated';
    case TenantApiKeyRevoked = 'tenant.api_key.revoked';
    case TenantLiveStatusChanged = 'tenant.live_status_changed';
    case NotificationTest = 'notification.test';
}
