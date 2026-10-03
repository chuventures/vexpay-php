<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum ManualOperationPollDtoKind: string
{
    case Debit = 'debit';
    case Payout = 'payout';
    case VerificationDeposit = 'verification_deposit';
}
