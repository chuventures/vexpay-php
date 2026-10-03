<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

/**
 * Venezuelan bank catalog (SIMF codes, supported services, logos).
 */
final class Banks extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     *
     * @return list<M\BankResponseDto>
     */
    public function list(array $options = []): array
    {
        return $this->models('Payments_getBanks', M\BankResponseDto::class, options: $options);
    }
}
