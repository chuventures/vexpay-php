<?php

declare(strict_types=1);

namespace VexPay\Resource\Balance;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Load your own Bs balance by Pago Móvil (money that is not a sale). Enabled per account
 * (`topups_not_enabled`, 403). Send the exact `amountVes` from `payerPhone` to the returned `receiver`
 * before `expiresAt`; the top-up completes when the transfer arrives. Each top-up needs a `sourceNote`
 * and counts against your monthly limit (`topup_cap_exceeded`, 422).
 */
final class Topups extends AbstractResource
{
    /**
     * Start a top-up (`amountVes`, `payerPhone`, `payerCedula`, `sourceNote`).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\TopupDto
    {
        return $this->model('Topups_create', M\TopupDto::class, body: $params, options: $options);
    }

    /**
     * Your latest top-ups (newest first, `limit` 1–100) plus this month's limit usage.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): M\TopupListDto
    {
        return $this->model('Topups_list', M\TopupListDto::class, query: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\TopupDto
    {
        return $this->model('Topups_get', M\TopupDto::class, ['id' => $id], options: $options);
    }

    /**
     * Release the still-held part of a completed top-up now, for `instantFeeVes`. Idempotent;
     * `not_held` (409) when nothing is held.
     *
     * @param array<string, mixed> $options
     */
    public function instant(string $id, array $options = []): M\TopupDto
    {
        return $this->model('Topups_instant', M\TopupDto::class, ['id' => $id], options: $options);
    }

    /**
     * Test mode only: complete the top-up as if the Pago Móvil arrived.
     *
     * @param array<string, mixed> $options
     */
    public function simulate(string $id, array $options = []): M\TopupDto
    {
        return $this->model('Topups_simulate', M\TopupDto::class, ['id' => $id], options: $options);
    }
}
