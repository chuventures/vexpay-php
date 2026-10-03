<?php

declare(strict_types=1);

namespace VexPay\Resource\Conversions;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * A rate for converting VES to USDT, locked for 60 seconds.
 */
final class Quotes extends AbstractResource
{
    /**
     * Send `sourceAmountVes` (VES to spend) or `targetAmountUsdt` (USDT to receive) — exactly one.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\ConversionQuoteDto
    {
        return $this->model('Conversions_createQuote', M\ConversionQuoteDto::class, body: $params, options: $options);
    }
}
