<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum OnwardPayoutStatusDtoStatus: string
{
    case Pending = 'pending';
    case Converting = 'converting';
    case WaitingRelease = 'waiting_release';
    case Sending = 'sending';
    case Completed = 'completed';
    case Held = 'held';
    case Failed = 'failed';
    case Canceled = 'canceled';
}
