<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Internal\Requester;
use VexPay\Resource\Cop\Balance;
use VexPay\Resource\Cop\Payments;

/**
 * Collect Colombian pesos (Bre-B, Nequi, Daviplata). COP must be enabled on your account
 * (403 `method_not_allowed` otherwise).
 */
final class Cop extends AbstractResource
{
    public readonly Payments $payments;
    public readonly Balance $balance;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->payments = new Payments($requester);
        $this->balance = new Balance($requester);
    }
}
