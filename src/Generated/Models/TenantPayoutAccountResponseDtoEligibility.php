<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum TenantPayoutAccountResponseDtoEligibility: string
{
    case PendingVerification = 'pending_verification';
    case Verifying = 'verifying';
    case Cooling = 'cooling';
    case Eligible = 'eligible';
    case Rejected = 'rejected';
    case Locked = 'locked';
}
