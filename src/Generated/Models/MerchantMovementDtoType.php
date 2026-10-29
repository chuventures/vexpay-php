<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum MerchantMovementDtoType: string
{
    case Credit = 'credit';
    case Release = 'release';
    case Reversal = 'reversal';
    case Payout = 'payout';
    case PayoutReversal = 'payout_reversal';
    case PayoutFee = 'payout_fee';
    case PayoutFeeReversal = 'payout_fee_reversal';
    case Adjustment = 'adjustment';
}
