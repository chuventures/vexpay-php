<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Internal\Requester;
use VexPay\Resource\Checkout\Sessions;

final class Checkout extends AbstractResource
{
    public readonly Sessions $sessions;

    public function __construct(Requester $requester)
    {
        parent::__construct($requester);
        $this->sessions = new Sessions($requester);
    }
}
