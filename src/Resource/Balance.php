<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Internal\Requester;
use VexPay\Resource\Balance\Transactions;

final class Balance extends AbstractResource
{
    public readonly Transactions $transactions;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->transactions = new Transactions($requester);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(array $options = []): M\PlatformBalanceDto
    {
        return $this->model('Balance_getBalance', M\PlatformBalanceDto::class, options: $options);
    }
}
