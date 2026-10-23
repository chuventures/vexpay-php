<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class InvoiceResponseDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $number,
        public readonly InvoiceResponseDtoStatus|string $status,
        public readonly string $customer,
        public readonly string $subscription,
        public readonly InvoiceResponseDtoCollectionMethod|string $collectionMethod,
        public readonly string $amountDueUsd,
        public readonly string $amountPaidUsd,
        public readonly string $currency,
        public readonly string $periodStart,
        public readonly string $periodEnd,
        /**
         * Invoices are due when issued.
         */
        public readonly string $dueDate,
        /**
         * Daily collection attempts for this invoice.
         */
        public readonly float $attemptsTotal,
        public readonly float $attemptCount,
        public readonly bool $paidOutOfBand,
        public readonly string $createdAt,
        public readonly bool $livemode,
        public readonly ?string $nextPaymentAttempt = null,
        public readonly ?string $paidAt = null,
        public readonly ?string $paymentId = null,
        public readonly ?InvoiceBillingFeeResponseDto $billingFee = null,
        public readonly ?string $hostedInvoiceUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            object: self::required($data, 'object'),
            number: self::required($data, 'number'),
            status: self::enumOrRaw(InvoiceResponseDtoStatus::class, self::required($data, 'status')),
            customer: self::required($data, 'customer'),
            subscription: self::required($data, 'subscription'),
            collectionMethod: self::enumOrRaw(InvoiceResponseDtoCollectionMethod::class, self::required($data, 'collectionMethod')),
            amountDueUsd: self::required($data, 'amountDueUsd'),
            amountPaidUsd: self::required($data, 'amountPaidUsd'),
            currency: self::required($data, 'currency'),
            periodStart: self::required($data, 'periodStart'),
            periodEnd: self::required($data, 'periodEnd'),
            dueDate: self::required($data, 'dueDate'),
            attemptsTotal: self::required($data, 'attemptsTotal'),
            attemptCount: self::required($data, 'attemptCount'),
            paidOutOfBand: self::required($data, 'paidOutOfBand'),
            createdAt: self::required($data, 'createdAt'),
            livemode: self::required($data, 'livemode'),
            nextPaymentAttempt: $data['nextPaymentAttempt'] ?? null,
            paidAt: $data['paidAt'] ?? null,
            paymentId: $data['paymentId'] ?? null,
            billingFee: isset($data['billingFee']) ? InvoiceBillingFeeResponseDto::fromArray($data['billingFee']) : null,
            hostedInvoiceUrl: $data['hostedInvoiceUrl'] ?? null,
        ))->withRaw($data);
    }
}
