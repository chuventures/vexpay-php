<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CopChannelDtoChannel: string
{
    case Breb = 'breb';
    case Nequi = 'nequi';
    case Daviplata = 'daviplata';
    case Card = 'card';
    case Pse = 'pse';
    case BancolombiaTransfer = 'bancolombia_transfer';
    case BancolombiaQr = 'bancolombia_qr';
}
