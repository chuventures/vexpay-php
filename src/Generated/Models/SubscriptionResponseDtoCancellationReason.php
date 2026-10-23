<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum SubscriptionResponseDtoCancellationReason: string
{
    case Requested = 'requested';
    case PaymentFailed = 'payment_failed';
}
