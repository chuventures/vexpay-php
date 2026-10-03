<?php

declare(strict_types=1);

namespace VexPay\Resource\Merchants;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Where a merchant gets paid (bank account or Pago Móvil).
 */
final class PayoutMethods extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function list(string $merchantId, array $options = []): M\PayoutMethodListResponseDto
    {
        return $this->model('Merchants_listPayoutMethods', M\PayoutMethodListResponseDto::class, ['id' => $merchantId], options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(string $merchantId, array $params, array $options = []): M\PayoutMethodResponseDto
    {
        return $this->model('Merchants_addPayoutMethod', M\PayoutMethodResponseDto::class, ['id' => $merchantId], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function setDefault(string $merchantId, string $methodId, array $options = []): M\PayoutMethodResponseDto
    {
        return $this->model('Merchants_setDefaultPayoutMethod', M\PayoutMethodResponseDto::class, ['id' => $merchantId, 'methodId' => $methodId], options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $merchantId, string $methodId, array $options = []): void
    {
        $this->none('Merchants_deletePayoutMethod', ['id' => $merchantId, 'methodId' => $methodId], $options);
    }

    /**
     * Send micro-deposits to this payout method.
     *
     * @param array<string, mixed> $options
     */
    public function startVerification(string $merchantId, string $methodId, array $options = []): M\VerifyStartResponseDto
    {
        return $this->model('Merchants_startVerifyMethod', M\VerifyStartResponseDto::class, ['id' => $merchantId, 'methodId' => $methodId], options: $options);
    }

    /**
     * Confirm the micro-deposit amounts the merchant saw.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function confirmVerification(string $merchantId, string $methodId, array $params, array $options = []): M\VerifyConfirmResponseDto
    {
        return $this->model('Merchants_confirmVerifyMethod', M\VerifyConfirmResponseDto::class, ['id' => $merchantId, 'methodId' => $methodId], body: $params, options: $options);
    }
}
