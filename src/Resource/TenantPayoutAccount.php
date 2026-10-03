<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

/**
 * The account your own VEXPay earnings are paid out to.
 */
final class TenantPayoutAccount extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(array $options = []): M\TenantPayoutAccountResponseDto
    {
        return $this->model('TenantPayoutAccount_get', M\TenantPayoutAccountResponseDto::class, options: $options);
    }

    /**
     * Create or replace the payout account (PUT).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function upsert(array $params, array $options = []): M\TenantPayoutAccountResponseDto
    {
        return $this->model('TenantPayoutAccount_upsert', M\TenantPayoutAccountResponseDto::class, body: $params, options: $options);
    }

    /**
     * Same as upsert(), sent as POST (supports `Idempotency-Key`).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\TenantPayoutAccountResponseDto
    {
        return $this->model('TenantPayoutAccount_upsertPost', M\TenantPayoutAccountResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function startVerification(array $options = []): M\TenantPayoutAccountVerifyStartResponseDto
    {
        return $this->model('TenantPayoutAccount_startVerify', M\TenantPayoutAccountVerifyStartResponseDto::class, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function confirmVerification(array $params, array $options = []): M\TenantPayoutAccountVerifyConfirmResponseDto
    {
        return $this->model('TenantPayoutAccount_confirmVerify', M\TenantPayoutAccountVerifyConfirmResponseDto::class, body: $params, options: $options);
    }
}
