<?php

declare(strict_types=1);

namespace VexPay\Webhook;

/**
 * `data` of every `payment.*` event. Lenient on purpose: a verified delivery never fails to
 * parse, and fields this SDK does not model stay in toArray().
 */
final class PaymentWebhookData
{
    /**
     * @param array<string, mixed> $raw
     */
    private function __construct(
        public readonly string $paymentId,
        /** PENDING | COMPLETED | FAILED | CANCELED | REVERSED */
        public readonly string $status,
        public readonly ?string $externalRef,
        /** C2P | VPOS | PAGO_MOVIL | DEBITO_INMEDIATO | USDT | USDC */
        public readonly ?string $method,
        public readonly ?float $usdAmount,
        public readonly ?float $vesAmount,
        /** Pago Móvil only, set when the payer sent more than asked (up to Bs 500 more): the bolívar amount originally asked. vesAmount/usdAmount are then what arrived. */
        public readonly ?float $requestedVesAmount,
        public readonly ?float $bcvRate,
        /** Rate the payment was priced at: bcvRate for BCV accounts, the market rate for MARKET accounts. */
        public readonly ?float $rate,
        /** BCV | MARKET */
        public readonly ?string $rateSource,
        public readonly ?float $feeUsd,
        public readonly ?float $feeVes,
        public readonly ?float $netVes,
        public readonly ?string $bankReference,
        public readonly ?string $failureCode,
        /** `superseded` | `expired` on payment.canceled */
        public readonly ?string $cancelReason,
        public readonly ?string $reversedAt,
        public readonly ?string $createdAt,
        public readonly ?bool $livemode,
        /** Present when the payment came from a checkout session. */
        public readonly ?CheckoutSessionRef $checkoutSession,
        /**
         * Pago Móvil paid in several transfers: each transfer counted so far, oldest first. On
         * payment.completed, on payment.pending (once per transfer that does not complete it yet)
         * and on an expired payment.failed that had money on it.
         *
         * @var list<PaymentWebhookTransfer>|null
         */
        public readonly ?array $transfers,
        /** payment.pending / expired payment.failed of a Pago Móvil paid in several transfers: bolívars received so far. */
        public readonly ?float $paidVesAmount,
        /** payment.pending of a Pago Móvil paid in several transfers: bolívars still missing. */
        public readonly ?float $missingVesAmount,
        /** payment.pending of a Pago Móvil paid in several transfers: when it expires if the rest does not arrive. */
        public readonly ?string $expiresAt,
        /** Expired payment.failed that had money on it: true. VEX Pay support refunds what arrived to the buyer. */
        public readonly ?bool $refundPending,
        private readonly array $raw,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $session = $data['checkoutSession'] ?? null;
        $transfers = $data['transfers'] ?? null;

        return new self(
            paymentId: (string) ($data['paymentId'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            externalRef: self::str($data, 'externalRef'),
            method: self::str($data, 'method'),
            usdAmount: self::num($data, 'usdAmount'),
            vesAmount: self::num($data, 'vesAmount'),
            requestedVesAmount: self::num($data, 'requestedVesAmount'),
            bcvRate: self::num($data, 'bcvRate'),
            rate: self::num($data, 'rate'),
            rateSource: self::str($data, 'rateSource'),
            feeUsd: self::num($data, 'feeUsd'),
            feeVes: self::num($data, 'feeVes'),
            netVes: self::num($data, 'netVes'),
            bankReference: self::str($data, 'bankReference'),
            failureCode: self::str($data, 'failureCode'),
            cancelReason: self::str($data, 'cancelReason'),
            reversedAt: self::str($data, 'reversedAt'),
            createdAt: self::str($data, 'createdAt'),
            livemode: isset($data['livemode']) ? (bool) $data['livemode'] : null,
            checkoutSession: is_array($session) && isset($session['id']) ? CheckoutSessionRef::fromArray($session) : null,
            transfers: is_array($transfers)
                ? array_values(array_map(
                    static fn ($t): PaymentWebhookTransfer => PaymentWebhookTransfer::fromArray(is_array($t) ? $t : []),
                    $transfers,
                ))
                : null,
            paidVesAmount: self::num($data, 'paidVesAmount'),
            missingVesAmount: self::num($data, 'missingVesAmount'),
            expiresAt: self::str($data, 'expiresAt'),
            refundPending: isset($data['refundPending']) ? (bool) $data['refundPending'] : null,
            raw: $data,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function str(array $data, string $key): ?string
    {
        $value = $data[$key] ?? null;

        return is_scalar($value) ? (string) $value : null;
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function num(array $data, string $key): ?float
    {
        $value = $data[$key] ?? null;

        return is_numeric($value) ? (float) $value : null;
    }
}
