<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum PayoutMethodResponseDtoStatus: string
{
    case PendingVerification = 'pending_verification';
    case Verifying = 'verifying';
    case Verified = 'verified';
    case Rejected = 'rejected';
}
