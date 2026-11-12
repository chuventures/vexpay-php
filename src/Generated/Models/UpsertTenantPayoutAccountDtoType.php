<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum UpsertTenantPayoutAccountDtoType: string
{
    case PagoMovil = 'pago_movil';
    case BankAccount = 'bank_account';
}
