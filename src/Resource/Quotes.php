<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

/**
 * USD → VES at the official BCV rate.
 */
final class Quotes extends AbstractResource
{
    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function retrieve(array $params, array $options = []): M\QuoteResponseDto
    {
        return $this->model('Payments_getQuote', M\QuoteResponseDto::class, query: $params, options: $options);
    }
}
