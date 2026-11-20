<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum PayoutBatchItemResultDtoHoldReason: string
{
    case NewAccountLimit = 'NEW_ACCOUNT_LIMIT';
    case FirstPayouts = 'FIRST_PAYOUTS';
    case BankUnfunded = 'BANK_UNFUNDED';
}
