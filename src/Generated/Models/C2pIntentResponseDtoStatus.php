<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum C2pIntentResponseDtoStatus: string
{
    case Pending = 'PENDING';
    case Completed = 'COMPLETED';
    case Failed = 'FAILED';
    case Canceled = 'CANCELED';
    case Reversed = 'REVERSED';
}
