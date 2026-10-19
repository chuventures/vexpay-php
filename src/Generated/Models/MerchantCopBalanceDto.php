<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantCopBalanceDto extends Model
{
    public function __construct(
        /**
         * COP sales still in the seller hold.
         */
        public readonly string $pendingCop,
        /**
         * COP the seller can pay out.
         */
        public readonly string $availableCop,
        /**
         * COP payouts requested and not yet paid.
         */
        public readonly string $payoutPendingCop,
        /**
         * COP paid out to the seller so far.
         */
        public readonly string $paidOutCop,
        /**
         * VEX Wallet sellers: COP per US$1 a wallet sweep would use now (display only). Omitted when no fresh rate.
         */
        public readonly ?string $sweepRate = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            pendingCop: self::required($data, 'pendingCop'),
            availableCop: self::required($data, 'availableCop'),
            payoutPendingCop: self::required($data, 'payoutPendingCop'),
            paidOutCop: self::required($data, 'paidOutCop'),
            sweepRate: $data['sweepRate'] ?? null,
        ))->withRaw($data);
    }
}
