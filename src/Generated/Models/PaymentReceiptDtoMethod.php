<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum PaymentReceiptDtoMethod: string
{
    case C2p = 'C2P';
    case Vpos = 'VPOS';
    case PagoMovil = 'PAGO_MOVIL';
    case DebitoInmediato = 'DEBITO_INMEDIATO';
}
