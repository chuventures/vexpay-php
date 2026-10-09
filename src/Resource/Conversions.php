<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Internal\Requester;
use VexPay\Pagination\CursorPage;
use VexPay\Resource\Conversions\Quotes;
use VexPay\Resource\Conversions\Settings;

/**
 * Convert available VES or COP into your USDT balance (enabled per account). Accepting a quote debits
 * the source at once (`conversion.created`); the conversion is `PENDING` until VEXPay delivers the USDT
 * (`conversion.completed`).
 */
final class Conversions extends AbstractResource
{
    public readonly Quotes $quotes;
    public readonly Settings $settings;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->quotes = new Quotes($requester);
        $this->settings = new Settings($requester);
    }

    /**
     * Accept a quote (`quoteId`). Pass `['idempotency_key' => …]` in options to retry safely.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\ConversionDto
    {
        return $this->model('Conversions_create', M\ConversionDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\ConversionDto
    {
        return $this->model('Conversions_get', M\ConversionDto::class, ['id' => $id], options: $options);
    }

    /**
     * First page of conversions (newest first); iterate the result for every conversion (`ConversionDto`).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Conversions_list', M\ConversionListDto::class, $params, $options);
    }

    /**
     * Cancel a `PENDING` conversion; the VES or COP returns to your available balance.
     *
     * @param array<string, mixed> $options
     */
    public function cancel(string $id, array $options = []): M\ConversionDto
    {
        return $this->model('Conversions_cancel', M\ConversionDto::class, ['id' => $id], options: $options);
    }
}
