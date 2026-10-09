<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum PaymentMethodAvailabilityDtoReason: string
{
    case NotEnabled = 'not_enabled';
    case ReceivingAccountNotConfigured = 'receiving_account_not_configured';
    case ProviderNotConfigured = 'provider_not_configured';
}
