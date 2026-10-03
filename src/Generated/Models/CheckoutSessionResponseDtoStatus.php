<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CheckoutSessionResponseDtoStatus: string
{
    case Open = 'open';
    case Processing = 'processing';
    case Paid = 'paid';
    case Failed = 'failed';
    case Expired = 'expired';
    case Canceled = 'canceled';
}
