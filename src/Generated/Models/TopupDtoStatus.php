<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum TopupDtoStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Expired = 'expired';
    case Failed = 'failed';
    case Reversed = 'reversed';
}
