<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Internal\Requester;
use VexPay\Pagination\CursorPage;
use VexPay\Resource\Merchants\PayoutMethods;

final class Merchants extends AbstractResource
{
    public readonly PayoutMethods $payoutMethods;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->payoutMethods = new PayoutMethods($requester);
    }

    /**
     * `externalRef` is required and is the idempotency key for merchant creation.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\MerchantResponseDto
    {
        return $this->model('Merchants_create', M\MerchantResponseDto::class, body: $params, options: $options);
    }

    /**
     * First page of merchants; iterate the result for every merchant (`MerchantResponseDto`).
     *
     * @param array<string, mixed> $params `limit`, `cursor`
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        unset($params['externalRef']);

        return $this->page('Merchants_listOrGetByRef', M\MerchantListResponseDto::class, $params, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\MerchantResponseDto
    {
        return $this->model('Merchants_getById', M\MerchantResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Look up a merchant by the `externalRef` you created it with.
     *
     * @param array<string, mixed> $options
     */
    public function retrieveByRef(string $externalRef, array $options = []): M\MerchantResponseDto
    {
        return $this->model('Merchants_listOrGetByRef', M\MerchantResponseDto::class, query: ['externalRef' => $externalRef], options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\MerchantResponseDto
    {
        return $this->model('Merchants_update', M\MerchantResponseDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): M\DeleteMerchantResponseDto
    {
        return $this->model('Merchants_remove', M\DeleteMerchantResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieveBalance(string $id, array $options = []): M\MerchantBalanceDto
    {
        return $this->model('Merchants_getBalance', M\MerchantBalanceDto::class, ['id' => $id], options: $options);
    }

    /**
     * Move VES between this merchant's balance and another.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function transfer(string $id, array $params, array $options = []): M\MerchantBalanceDto
    {
        return $this->model('Merchants_transfer', M\MerchantBalanceDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function listAuditEvents(string $id, array $options = []): M\MerchantAuditEventListDto
    {
        return $this->model('Merchants_listAuditEvents', M\MerchantAuditEventListDto::class, ['id' => $id], options: $options);
    }

    /**
     * Send micro-deposits to the merchant's default payout method.
     *
     * @param array<string, mixed> $options
     */
    public function startVerification(string $id, array $options = []): M\VerifyStartResponseDto
    {
        return $this->model('Merchants_startVerify', M\VerifyStartResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function confirmVerification(string $id, array $params, array $options = []): M\VerifyConfirmResponseDto
    {
        return $this->model('Merchants_confirmVerify', M\VerifyConfirmResponseDto::class, ['id' => $id], body: $params, options: $options);
    }
}
