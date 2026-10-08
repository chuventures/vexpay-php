<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum BalanceTransactionDtoType: string
{
    case Payment = 'payment';
    case Fee = 'fee';
    case PaymentReversal = 'payment_reversal';
    case FeeReversal = 'fee_reversal';
    case Payout = 'payout';
    case PayoutReversal = 'payout_reversal';
    case Chargeback = 'chargeback';
    case ChargebackFee = 'chargeback_fee';
    case ChargebackReversal = 'chargeback_reversal';
    case Adjustment = 'adjustment';
    case SellerTransfer = 'seller_transfer';
    case SellerTransferReversal = 'seller_transfer_reversal';
    case Conversion = 'conversion';
    case ConversionReversal = 'conversion_reversal';
}
