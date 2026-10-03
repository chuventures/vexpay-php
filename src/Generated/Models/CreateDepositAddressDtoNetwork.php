<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CreateDepositAddressDtoNetwork: string
{
    case Trc20 = 'TRC20';
    case Bep20 = 'BEP20';
    case Polygon = 'POLYGON';
    case Sol = 'SOL';
    case Ton = 'TON';
    case Arb1 = 'ARB1';
    case Base = 'BASE';
}
