<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Internal\Requester;
use VexPay\Resource\Crypto\Balance as CryptoBalance;
use VexPay\Resource\Crypto\Balances;
use VexPay\Resource\Crypto\DepositAddresses;
use VexPay\Resource\Crypto\Networks;
use VexPay\Resource\Crypto\Payouts as CryptoPayouts;

/**
 * Stablecoins (USDT, USDC): deposit addresses, balances, networks and payouts.
 */
final class Crypto extends AbstractResource
{
    public readonly CryptoBalance $balance;
    public readonly Balances $balances;
    public readonly DepositAddresses $depositAddresses;
    public readonly Networks $networks;
    public readonly CryptoPayouts $payouts;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->balance = new CryptoBalance($requester);
        $this->balances = new Balances($requester);
        $this->depositAddresses = new DepositAddresses($requester);
        $this->networks = new Networks($requester);
        $this->payouts = new CryptoPayouts($requester);
    }
}
