<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum UpdateSubscriptionDtoCollectionMethod: string
{
    case SendInvoice = 'send_invoice';
    case ChargeAutomatically = 'charge_automatically';
}
