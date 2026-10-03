<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum MerchantResponseDtoAccountStatus: string
{
    case Active = 'active';
    case Pending = 'pending';
    case Restricted = 'restricted';
    case Rejected = 'rejected';
}
