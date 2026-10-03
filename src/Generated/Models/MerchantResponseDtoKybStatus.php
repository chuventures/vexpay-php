<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum MerchantResponseDtoKybStatus: string
{
    case NotRequired = 'not_required';
    case Required = 'required';
    case Pending = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';
}
