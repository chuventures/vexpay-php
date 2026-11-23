<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum OneShotPaymentLinkDtoStatus: string
{
    case Active = 'ACTIVE';
    case Paid = 'PAID';
    case Expired = 'EXPIRED';
    case Cancelled = 'CANCELLED';
}
