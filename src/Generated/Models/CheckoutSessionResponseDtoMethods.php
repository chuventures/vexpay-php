<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CheckoutSessionResponseDtoMethods: string
{
    case C2p = 'c2p';
    case Vpos = 'vpos';
    case Usdt = 'usdt';
    case Usdc = 'usdc';
}
