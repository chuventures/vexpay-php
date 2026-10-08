<?php

declare(strict_types=1);

namespace VexPay\Resource\Balance;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;
use VexPay\Resource\AbstractResource;

/**
 * Every movement in your VES balance (payments, fees, payouts, chargebacks, …), newest first.
 * The amounts sum to `ledgerNetVes` from `balance->retrieve()`.
 */
final class Transactions extends AbstractResource
{
    /**
     * First page of movements; iterate the result for every movement (`BalanceTransactionDto`).
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function list(array $params = [], array $options = []): CursorPage
    {
        return $this->page('Balance_listTransactions', M\BalanceTransactionListDto::class, $params, $options);
    }
}
