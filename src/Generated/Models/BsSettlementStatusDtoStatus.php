<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum BsSettlementStatusDtoStatus: string
{
    case Active = 'active';
    case NoPayoutAccount = 'no_payout_account';
    case PayoutAccountUnverified = 'payout_account_unverified';
    case PayoutAccountCooling = 'payout_account_cooling';
    case Paused = 'paused';
    case OptedOut = 'opted_out';
    case Disbursements = 'disbursements';
    case TestMode = 'test_mode';
}
