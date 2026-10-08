<?php

declare(strict_types=1);

namespace VexPay;

use VexPay\Internal\Config;
use VexPay\Internal\Requester;
use VexPay\Resource\Balance;
use VexPay\Resource\Banks;
use VexPay\Resource\Checkout;
use VexPay\Resource\Conversions;
use VexPay\Resource\Cop;
use VexPay\Resource\Crypto;
use VexPay\Resource\Merchants;
use VexPay\Resource\PaymentLinks;
use VexPay\Resource\Payments;
use VexPay\Resource\Payouts;
use VexPay\Resource\Products;
use VexPay\Resource\Quotes;
use VexPay\Resource\TenantPayoutAccount;
use VexPay\Resource\WebhookEndpoints;

/**
 * VEXPay API client.
 *
 *     $vexpay = new VexPayClient(getenv('VEXPAY_API_KEY'));
 *     $vexpay = new VexPayClient([
 *         'api_key' => getenv('VEXPAY_API_KEY'),
 *         'base_url' => 'https://api.pay.vexwallet.co',
 *         'timeout' => 30,              // seconds per attempt
 *         'max_network_retries' => 2,
 *         'http_client' => $psr18Client, // optional; Guzzle by default
 *     ]);
 */
final class VexPayClient
{
    public readonly Banks $banks;
    public readonly Quotes $quotes;
    public readonly Balance $balance;
    public readonly Payments $payments;
    public readonly Checkout $checkout;
    public readonly Merchants $merchants;
    public readonly Payouts $payouts;
    /** Stablecoins (USDT, USDC): deposit addresses, balances, networks and payouts. */
    public readonly Crypto $crypto;
    /** Convert available VES to USDT (enabled per account). */
    public readonly Conversions $conversions;
    /** Colombian pesos: Bre-B, Nequi and Daviplata payments and the COP balance. */
    public readonly Cop $cop;
    public readonly Products $products;
    public readonly PaymentLinks $paymentLinks;
    public readonly TenantPayoutAccount $tenantPayoutAccount;
    public readonly WebhookEndpoints $webhookEndpoints;

    private readonly Requester $requester;

    /**
     * @param string|array{api_key: string, base_url?: string, timeout?: int|float, max_network_retries?: int, http_client?: \Psr\Http\Client\ClientInterface, request_factory?: \Psr\Http\Message\RequestFactoryInterface, stream_factory?: \Psr\Http\Message\StreamFactoryInterface} $config
     *        an API key, or an options array
     */
    public function __construct(string|array $config)
    {
        $this->requester = new Requester(new Config(is_string($config) ? ['api_key' => $config] : $config));

        $this->banks = new Banks($this->requester);
        $this->quotes = new Quotes($this->requester);
        $this->balance = new Balance($this->requester);
        $this->payments = new Payments($this->requester);
        $this->checkout = new Checkout($this->requester);
        $this->merchants = new Merchants($this->requester);
        $this->payouts = new Payouts($this->requester);
        $this->crypto = new Crypto($this->requester);
        $this->conversions = new Conversions($this->requester);
        $this->cop = new Cop($this->requester);
        $this->products = new Products($this->requester);
        $this->paymentLinks = new PaymentLinks($this->requester);
        $this->tenantPayoutAccount = new TenantPayoutAccount($this->requester);
        $this->webhookEndpoints = new WebhookEndpoints($this->requester);
    }

    public function banks(): Banks
    {
        return $this->banks;
    }

    public function quotes(): Quotes
    {
        return $this->quotes;
    }

    public function balance(): Balance
    {
        return $this->balance;
    }

    public function payments(): Payments
    {
        return $this->payments;
    }

    public function checkout(): Checkout
    {
        return $this->checkout;
    }

    public function merchants(): Merchants
    {
        return $this->merchants;
    }

    public function payouts(): Payouts
    {
        return $this->payouts;
    }

    public function crypto(): Crypto
    {
        return $this->crypto;
    }

    public function conversions(): Conversions
    {
        return $this->conversions;
    }

    public function cop(): Cop
    {
        return $this->cop;
    }

    public function products(): Products
    {
        return $this->products;
    }

    public function paymentLinks(): PaymentLinks
    {
        return $this->paymentLinks;
    }

    public function tenantPayoutAccount(): TenantPayoutAccount
    {
        return $this->tenantPayoutAccount;
    }

    public function webhookEndpoints(): WebhookEndpoints
    {
        return $this->webhookEndpoints;
    }
}
