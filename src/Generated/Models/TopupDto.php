<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class TopupDto extends Model
{
    public function __construct(
        public readonly string $id,
        public readonly TopupDtoStatus|string $status,
        public readonly string $amountVes,
        /**
         * USD at the BCV rate snapshotted at creation.
         */
        public readonly string $amountUsd,
        public readonly string $bcvRate,
        public readonly string $feePercent,
        public readonly string $feeFixedUsd,
        public readonly string $sourceNote,
        public readonly string $payerPhone,
        public readonly string $expiresAt,
        /**
         * Part of this top-up still held.
         */
        public readonly string $heldVes,
        /**
         * Instant availability fee percent.
         */
        public readonly string $instantFeePercent,
        /**
         * Fee to release heldVes now.
         */
        public readonly string $instantFeeVes,
        public readonly bool $test,
        public readonly string $createdAt,
        /**
         * Charged when the top-up completes.
         */
        public readonly ?string $feeVes = null,
        /**
         * Credited to your balance (amount − fee).
         */
        public readonly ?string $creditedVes = null,
        public readonly ?string $bankReference = null,
        public readonly ?string $completedAt = null,
        /**
         * When the credit becomes available on its own (null = available).
         */
        public readonly ?string $availableAt = null,
        /**
         * When the held part was released early with the instant fee.
         */
        public readonly ?string $instantReleasedAt = null,
        /**
         * Where to send the Pago Móvil (pending only).
         */
        public readonly ?TopupReceiverDto $receiver = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            id: self::required($data, 'id'),
            status: self::enumOrRaw(TopupDtoStatus::class, self::required($data, 'status')),
            amountVes: self::required($data, 'amountVes'),
            amountUsd: self::required($data, 'amountUsd'),
            bcvRate: self::required($data, 'bcvRate'),
            feePercent: self::required($data, 'feePercent'),
            feeFixedUsd: self::required($data, 'feeFixedUsd'),
            sourceNote: self::required($data, 'sourceNote'),
            payerPhone: self::required($data, 'payerPhone'),
            expiresAt: self::required($data, 'expiresAt'),
            heldVes: self::required($data, 'heldVes'),
            instantFeePercent: self::required($data, 'instantFeePercent'),
            instantFeeVes: self::required($data, 'instantFeeVes'),
            test: self::required($data, 'test'),
            createdAt: self::required($data, 'createdAt'),
            feeVes: $data['feeVes'] ?? null,
            creditedVes: $data['creditedVes'] ?? null,
            bankReference: $data['bankReference'] ?? null,
            completedAt: $data['completedAt'] ?? null,
            availableAt: $data['availableAt'] ?? null,
            instantReleasedAt: $data['instantReleasedAt'] ?? null,
            receiver: isset($data['receiver']) ? TopupReceiverDto::fromArray($data['receiver']) : null,
        ))->withRaw($data);
    }
}
