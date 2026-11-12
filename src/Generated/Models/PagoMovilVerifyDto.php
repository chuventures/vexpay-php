<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class PagoMovilVerifyDto extends Model
{
    public function __construct(
        public readonly float $usdAmount,
        public readonly string $reference,
        public readonly ?string $dateMovement = null,
        /**
         * Correlation value; not an idempotency key.
         */
        public readonly ?string $externalRef = null,
        /**
         * Payer bank SIMF code. Required for some receiving banks — send it whenever you have it.
         */
        public readonly ?string $debtorBankCode = null,
        /**
         * Instrument type, required by some receiving banks. Defaults to transferencia.
         */
        public readonly PagoMovilVerifyDtoTxType|string|null $txType = null,
        /**
         * Payer Pago Móvil phone (11-digit local, e.g. 04149333844). Required by some receiving banks when txType is pago_movil — send it whenever you have it.
         */
        public readonly ?string $debtorCellPhone = null,
        /**
         * Convert this payment's net VES to USDT once it completes and send it to this wallet. Needs USDT and conversions enabled; not allowed with merchantId. See the "Pay in bolívars, receive USDT" guide.
         */
        public readonly ?OnwardPayoutDto $onwardPayout = null,
        /**
         * Split this payment between up to 10 of your merchants (marketplace). Each merchant is credited its share minus its part of the VEX Pay fee and your commission when the bank confirms the payment; the rest stays with your account. Not with merchantId / applicationFeeVes / applicationFeePercent, and not with onwardPayout. See the "Marketplace: split one payment between comercios" guide.
         *
         * @var list<SplitShareDto>|null
         */
        public readonly ?array $splits = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            usdAmount: self::required($data, 'usdAmount'),
            reference: self::required($data, 'reference'),
            dateMovement: $data['dateMovement'] ?? null,
            externalRef: $data['externalRef'] ?? null,
            debtorBankCode: $data['debtorBankCode'] ?? null,
            txType: isset($data['txType']) ? self::enumOrRaw(PagoMovilVerifyDtoTxType::class, $data['txType']) : null,
            debtorCellPhone: $data['debtorCellPhone'] ?? null,
            onwardPayout: isset($data['onwardPayout']) ? OnwardPayoutDto::fromArray($data['onwardPayout']) : null,
            splits: isset($data['splits']) ? self::listOf(SplitShareDto::class, $data['splits']) : null,
        ))->withRaw($data);
    }
}
