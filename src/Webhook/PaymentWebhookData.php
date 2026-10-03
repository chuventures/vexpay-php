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
        public readonly ?float $bcvRate,
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
        private readonly array $raw,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $session = $data['checkoutSession'] ?? null;

        return new self(
            paymentId: (string) ($data['paymentId'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            externalRef: self::str($data, 'externalRef'),
            method: self::str($data, 'method'),
            usdAmount: self::num($data, 'usdAmount'),
            vesAmount: self::num($data, 'vesAmount'),
            bcvRate: self::num($data, 'bcvRate'),
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
