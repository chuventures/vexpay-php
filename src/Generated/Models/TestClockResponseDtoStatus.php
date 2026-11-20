<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum TestClockResponseDtoStatus: string
{
    case Ready = 'ready';
    case Advancing = 'advancing';
    case InternalFailure = 'internal_failure';
}
