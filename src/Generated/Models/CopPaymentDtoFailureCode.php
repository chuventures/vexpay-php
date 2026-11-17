<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum CopPaymentDtoFailureCode: string
{
    case Expired = 'expired';
    case Rejected = 'rejected';
    case ProcessorError = 'processor_error';
    case ProcessorUnknown = 'processor_unknown';
}
