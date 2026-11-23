<?php

// Generated from packages/vexpay/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

enum WebhookDeliveryDtoStatus: string
{
    case Pending = 'pending';
    case Retrying = 'retrying';
    case Success = 'success';
    case Failed = 'failed';
}
