<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum PayoutResponseDtoStatus: string
{
    case Completed = 'completed';
    case Pending = 'pending';
    case Failed = 'failed';
}
