<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Internal\Requester;
use VexPay\Resource\Cop\Balance;
use VexPay\Resource\Cop\Payments;

/**
 * Collect Colombian pesos (PSE, Bancolombia, Bre-B, Nequi, Daviplata; cards via the hosted checkout).
 * COP must be enabled on your account
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

    /**
     * Channels you can use right now, with what each needs, plus the PSE banks and terms links.
     *
     * @param array<string, mixed> $options
     */
    public function channels(array $options = []): M\CopChannelsDto
    {
        return $this->model('CopPayments_channels', M\CopChannelsDto::class, options: $options);
    }
}
