<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantBalanceDto extends Model
{
    public function __construct(
        public readonly string $merchantId,
        public readonly string $accountId,
        public readonly string $tenantId,
        public readonly string $pendingVes,
        public readonly string $availableVes,
        public readonly string $paidOutVes,
        public readonly string $ledgerNetVes,
        /**
         * COP balances from COP sales on seller links. Present only once the seller has COP activity.
         */
        public readonly ?MerchantCopBalanceDto $cop = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (new self(
            merchantId: self::required($data, 'merchantId'),
            accountId: self::required($data, 'accountId'),
            tenantId: self::required($data, 'tenantId'),
            pendingVes: self::required($data, 'pendingVes'),
            availableVes: self::required($data, 'availableVes'),
            paidOutVes: self::required($data, 'paidOutVes'),
            ledgerNetVes: self::required($data, 'ledgerNetVes'),
            cop: isset($data['cop']) ? MerchantCopBalanceDto::fromArray($data['cop']) : null,
        ))->withRaw($data);
    }
}
