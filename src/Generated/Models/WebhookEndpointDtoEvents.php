<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum WebhookEndpointDtoEvents: string
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
    case OnwardPayoutUpdated = 'onward_payout.updated';
    case TenantStatusChanged = 'tenant.status_changed';
    case TenantApiKeyCreated = 'tenant.api_key.created';
    case TenantApiKeyRotated = 'tenant.api_key.rotated';
    case TenantApiKeyRevoked = 'tenant.api_key.revoked';
    case TenantLiveStatusChanged = 'tenant.live_status_changed';
    case CustomerCreated = 'customer.created';
    case CustomerUpdated = 'customer.updated';
    case CustomerDeleted = 'customer.deleted';
    case CustomerSubscriptionCreated = 'customer.subscription.created';
    case CustomerSubscriptionUpdated = 'customer.subscription.updated';
    case CustomerSubscriptionDeleted = 'customer.subscription.deleted';
    case CustomerSubscriptionTrialWillEnd = 'customer.subscription.trial_will_end';
    case CustomerSubscriptionReactivated = 'customer.subscription.reactivated';
    case InvoiceCreated = 'invoice.created';
    case InvoiceUpcoming = 'invoice.upcoming';
    case InvoicePaid = 'invoice.paid';
    case InvoicePaymentAttempt = 'invoice.payment_attempt';
    case InvoicePaymentFailed = 'invoice.payment_failed';
    case InvoiceOverdue = 'invoice.overdue';
    case InvoiceVoided = 'invoice.voided';
    case InvoiceMarkedUncollectible = 'invoice.marked_uncollectible';
    case PaymentMethodAttached = 'payment_method.attached';
    case PaymentMethodUpdated = 'payment_method.updated';
    case PaymentMethodDetached = 'payment_method.detached';
    case NotificationTest = 'notification.test';
}
