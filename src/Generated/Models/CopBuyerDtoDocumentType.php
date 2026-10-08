<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CopBuyerDtoDocumentType: string
{
    case Cc = 'CC';
    case Ce = 'CE';
    case Ti = 'TI';
    case Nit = 'NIT';
    case Pp = 'PP';
}
