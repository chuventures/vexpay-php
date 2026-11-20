<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum ManualOperationPollResponseDtoKind: string
{
    case Debit = 'debit';
    case Payout = 'payout';
    case VerificationDeposit = 'verification_deposit';
}
