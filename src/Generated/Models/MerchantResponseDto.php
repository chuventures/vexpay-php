<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\Generated\Models;

use VexPay\Model;

final class MerchantResponseDto extends Model
{
    public function __construct(
        public readonly string $merchantId,
        public readonly string $accountId,
        public readonly string $externalRef,
        /**
         * Mirrored from the default payout method
         */
        public readonly MerchantResponseDtoStatus|string $status,
        /**
         * When false, merchant cannot receive new payouts
         */
        public readonly bool $isActive,
        public readonly ?string $name = null,
        /**
         * When true, available balance is auto-paid to the default verified method.
         */
        public readonly ?bool $autoPayoutEnabled = null,
        /**
         * Merchant-specific marketplace commission percent. null = the tenant's default commission applies.
         */
        public readonly ?float $applicationFeePercent = null,
        /**
         * Default method bank code (compat)
         */
        public readonly ?string $bankCode = null,
        /**
         * Masked default method phone (compat)
         */
        public readonly ?string $destination = null,
        /**
         * @var list<PayoutMethodResponseDto>|null
         */
        public readonly ?array $payoutMethods = null,
        /**
         * Present when the merchant has no payout methods yet (e.g. created without bankCode/phone)
         */
        public readonly ?string $message = null,
        public readonly ?string $failureCode = null,
        /**
         * ISO timestamp; when set and in the future, verification is locked
         */
        public readonly ?string $lockedUntil = null,
        /**
         * ISO timestamp when the merchant was deactivated
         */
        public readonly ?string $deactivatedAt = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $verifiedAt = null,
        /**
         * How the merchant was created.
         */
        public readonly MerchantResponseDtoOwnerType|string|null $ownerType = null,
        public readonly MerchantResponseDtoMerchantType|string|null $merchantType = null,
        public readonly ?string $displayName = null,
        /**
         * VEX Wallet user id (`ownerType = "wallet"`).
         */
        public readonly ?string $walletUserId = null,
        public readonly ?string $rifNumber = null,
        /**
         * VEX Pay-owned compliance lifecycle, independent of payout `status`.
         */
        public readonly MerchantResponseDtoAccountStatus|string|null $accountStatus = null,
        public readonly MerchantResponseDtoKybStatus|string|null $kybStatus = null,
        public readonly ?string $restrictionReason = null,
        public readonly ?string $activatedAt = null,
        /**
         * Effective payment capabilities (stored grant AND accountStatus = active). Null for merchants with no capabilities row.
         *
         * @var array<string, mixed>|null
         */
        public readonly ?array $capabilities = null,
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
            externalRef: self::required($data, 'externalRef'),
            status: self::enumOrRaw(MerchantResponseDtoStatus::class, self::required($data, 'status')),
            isActive: self::required($data, 'isActive'),
            name: $data['name'] ?? null,
            autoPayoutEnabled: $data['autoPayoutEnabled'] ?? null,
            applicationFeePercent: $data['applicationFeePercent'] ?? null,
            bankCode: $data['bankCode'] ?? null,
            destination: $data['destination'] ?? null,
            payoutMethods: isset($data['payoutMethods']) ? self::listOf(PayoutMethodResponseDto::class, $data['payoutMethods']) : null,
            message: $data['message'] ?? null,
            failureCode: $data['failureCode'] ?? null,
            lockedUntil: $data['lockedUntil'] ?? null,
            deactivatedAt: $data['deactivatedAt'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            verifiedAt: $data['verifiedAt'] ?? null,
            ownerType: isset($data['ownerType']) ? self::enumOrRaw(MerchantResponseDtoOwnerType::class, $data['ownerType']) : null,
            merchantType: isset($data['merchantType']) ? self::enumOrRaw(MerchantResponseDtoMerchantType::class, $data['merchantType']) : null,
            displayName: $data['displayName'] ?? null,
            walletUserId: $data['walletUserId'] ?? null,
            rifNumber: $data['rifNumber'] ?? null,
            accountStatus: isset($data['accountStatus']) ? self::enumOrRaw(MerchantResponseDtoAccountStatus::class, $data['accountStatus']) : null,
            kybStatus: isset($data['kybStatus']) ? self::enumOrRaw(MerchantResponseDtoKybStatus::class, $data['kybStatus']) : null,
            restrictionReason: $data['restrictionReason'] ?? null,
            activatedAt: $data['activatedAt'] ?? null,
            capabilities: $data['capabilities'] ?? null,
        ))->withRaw($data);
    }
}
